#!/bin/bash
# Script de verificación del enlace simbólico de storage para sistemas Unix/Linux/Mac
# Autor: Sistema de Gestión de Ofertas Educativas SENA
# Fecha: 2026-01-28

echo "==================================="
echo "Verificación de Storage Link"
echo "==================================="
echo ""

# Verificar si existe public/storage
if [ -L "public/storage" ]; then
    target=$(readlink "public/storage")
    echo "✓ Enlace simbólico existe: public/storage -> $target"
    
    # Verificar que el directorio de destino existe
    if [ -d "public/storage" ]; then
        echo "✓ Directorio de destino válido"
    else
        echo "✗ ERROR: El directorio de destino NO existe"
        echo "  Ejecuta: php artisan storage:link"
    fi
elif [ -e "public/storage" ]; then
    echo "✗ ERROR: public/storage existe pero NO es un enlace simbólico válido"
    echo "  Solución: rm -rf public/storage && php artisan storage:link"
else
    echo "✗ ERROR: No existe el enlace simbólico public/storage"
    echo "  Ejecuta: php artisan storage:link"
fi

echo ""

# Verificar que existe storage/app/public
if [ -d "storage/app/public" ]; then
    echo "✓ Directorio storage/app/public existe"
else
    echo "✗ ERROR: No existe el directorio storage/app/public"
    echo "  Ejecuta: mkdir -p storage/app/public"
fi

echo ""
echo "==================================="
echo "Verificación completada"
echo "==================================="
