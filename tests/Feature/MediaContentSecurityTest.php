<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CustomContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaContentSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario con permiso
        $this->user = User::factory()->create();
        
        // Asegurar que el permiso existe y asignarlo
        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'public_content.edit']);
        $this->user->givePermissionTo($permission);

        // Mock storage
        Storage::fake('public');
    }

    /**
     * ✅ TEST 1: Path Traversal - Rechazar rutas maliciosas
     */
    public function test_path_traversal_attack_is_rejected_in_store()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => '../../../../.env',  // Ataque de path traversal
            'type' => 'image',
            'metadata' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file_path']);
    }

    /**
     * ✅ TEST 2: Path Traversal con .. en medio de la ruta
     */
    public function test_path_traversal_with_dots_is_rejected()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => 'media/../../../.env',
            'type' => 'image',
            'metadata' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'Ruta de archivo no válida (path traversal detectado)'
        ]);
    }

    /**
     * ✅ TEST 3: Validación de existencia - Rechazar archivos inexistentes
     */
    public function test_nonexistent_file_is_rejected()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => 'media/ofertas/nonexistent.jpg',
            'type' => 'image',
            'metadata' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'El archivo no existe en el servidor'
        ]);
    }

    /**
     * ✅ TEST 4: Upload válido es aceptado
     */
    public function test_valid_image_upload_succeeds()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg', 800, 600);

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'file_path',
            'url',
            'metadata'
        ]);

        // Verificar que el archivo se guardó
        $filePath = $response->json('file_path');
        Storage::disk('public')->assertExists($filePath);
    }

    /**
     * ✅ TEST 5: Eliminación en cascada - Referencias eliminadas
     */
    public function test_file_deletion_cascades_to_references()
    {
        $this->actingAs($this->user);

        // Crear archivo en storage
        Storage::disk('public')->put('media/ofertas/test.jpg', 'fake content');

        // Crear múltiples referencias
        CustomContent::create([
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 0,
            'key' => 'banner_image',
            'value' => 'media/ofertas/test.jpg',
            'type' => 'image'
        ]);

        CustomContent::create([
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 1,
            'key' => 'imagen',
            'value' => 'media/ofertas/test.jpg',
            'type' => 'image'
        ]);

        // Verificar que existen 2 referencias
        $this->assertEquals(2, CustomContent::where('value', 'media/ofertas/test.jpg')->count());

        // Eliminar archivo
        $response = $this->deleteJson('/public/media/delete', [
            'file_path' => 'media/ofertas/test.jpg'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);
        
        // Verificar que las referencias fueron eliminadas
        $this->assertEquals(0, CustomContent::where('value', 'media/ofertas/test.jpg')->count());
        
        // Verificar que el archivo fue eliminado
        Storage::disk('public')->assertMissing('media/ofertas/test.jpg');
    }

    /**
     * ✅ TEST 6: Categoría inválida es rechazada
     */
    public function test_invalid_category_is_rejected()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => '../../../malicious'  // Categoría maliciosa
        ]);

        $response->assertStatus(422);
    }

    /**
     * ✅ TEST 7: Usuario sin permisos no puede subir archivos
     */
    public function test_unauthorized_user_cannot_upload()
    {
        // Usuario sin permisos
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $response->assertStatus(403);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'No tienes permisos para subir archivos'
        ]);
    }

    /**
     * ✅ TEST 8: Store con archivo existente funciona correctamente
     */
    public function test_store_with_existing_file_succeeds()
    {
        $this->actingAs($this->user);

        // Primero subir archivo
        $file = UploadedFile::fake()->image('test.jpg');
        $uploadResponse = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $filePath = $uploadResponse->json('file_path');

        // Luego guardar referencia
        $storeResponse = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => $filePath,
            'type' => 'image',
            'metadata' => [
                'width' => 1200,
                'height' => 600
            ]
        ]);

        $storeResponse->assertStatus(200);

        // Verificar en BD
        $this->assertDatabaseHas('custom_contents', [
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 0,
            'key' => 'banner_image',
            'value' => $filePath,
            'type' => 'image'
        ]);
    }
}
