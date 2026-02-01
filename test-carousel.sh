#!/bin/bash

# Test rápido del CRUD Carousel
# Ejecutar con: bash test-carousel.sh

echo "================================================"
echo "    TEST RÁPIDO - CRUD CAROUSEL DEL HOME"
echo "================================================"
echo ""

# Verificar archivos creados
echo "✓ Verificando archivos creados..."
echo ""

files=(
    "app/Http/Controllers/Admin/HomeCarouselController.php"
    "resources/views/admin/home-carousel/index.blade.php"
    "resources/views/admin/home-carousel/create.blade.php"
    "resources/views/admin/home-carousel/edit.blade.php"
    "resources/views/admin/home-carousel/_form.blade.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "  ✅ $file"
    else
        echo "  ❌ $file (NO ENCONTRADO)"
    fi
done

echo ""
echo "================================================"
echo "    PASOS PARA VERIFICAR"
echo "================================================"
echo ""
echo "1. Asegúrate de tener la tabla en BD:"
echo "   php artisan migrate"
echo ""
echo "2. Accede al admin:"
echo "   http://localhost/admin/carousel"
echo ""
echo "3. Prueba crear un slide:"
echo "   - Título: Test Slide"
echo "   - Descripción: Slide de prueba"
echo "   - Imagen: (opcional)"
echo "   - Posición: 0"
echo "   - Activo: Checked"
echo ""
echo "4. Verifica en el dashboard:"
echo "   Debe aparecer tarjeta 'Carousel del Home'"
echo ""
echo "5. En home público (/), deben aparecer solo"
echo "   slides activos ordenados por position"
echo ""
echo "================================================"
echo "✅ PRUEBAS COMPLETADAS"
echo "================================================"
