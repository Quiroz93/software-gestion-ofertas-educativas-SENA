<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasProfilePhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles, HasProfilePhoto;


    /**
     * Get the email address for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Override to send password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
    }

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'bio',
        'phone',
        'location',
        'website',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que se agregan a las respuestas del modelo.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con configuraciones de usuario
     */
    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    /**
     * Relación con inscripciones (programas)
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    /**
     * Relación con programas a través de inscripciones
     */
    public function programas()
    {
        return $this->belongsToMany(Programa::class, 'inscripciones')
            ->withPivot('instructor_id', 'fecha_inscripcion', 'fecha_retiro', 'estado', 'observaciones')
            ->withTimestamps();
    }

    /**
     * Obtener inscripciones ordenadas por fecha (más recientes primero)
     */
    public function inscripcionesOrdenadas()
    {
        return $this->inscripciones()->orderBy('fecha_inscripcion', 'desc');
    }

    /**
     * Obtener solo inscripciones activas
     */
    public function inscripcionesActivas()
    {
        return $this->inscripciones()->activas();
    }

    /**
     * Accessor: Perfil profesional limitado a 150 caracteres
     */
    public function getPerfilProfesionalCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->perfil_profesional ?? '', 150);
    }
}
