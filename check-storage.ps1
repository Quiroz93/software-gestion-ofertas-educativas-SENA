# Script de verificación del enlace simbólico de storage
# Autor: Sistema de Gestión de Ofertas Educativas SENA
# Fecha: 2026-01-28

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "Verificación de Storage Link" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

# Verificar si existe public/storage
if (Test-Path "public\storage") {
    $link = Get-Item "public\storage"
    
    # Verificar si es un enlace simbólico o junction válido
    if (($link.LinkType -eq "SymbolicLink" -or $link.LinkType -eq "Junction") -and $link.Target) {
        $linkTypeDesc = if ($link.LinkType -eq "Junction") { "Junction Point" } else { "Symbolic Link" }
        Write-Host "✓ $linkTypeDesc existe: public\storage -> $($link.Target)" -ForegroundColor Green
        
        # Verificar que el directorio de destino existe
        if (Test-Path $link.Target[0]) {
            Write-Host "✓ Directorio de destino válido: $($link.Target[0])" -ForegroundColor Green
        } else {
            Write-Host "✗ ERROR: El directorio de destino NO existe: $($link.Target[0])" -ForegroundColor Red
            Write-Host "  Ejecuta: php artisan storage:link" -ForegroundColor Yellow
        }
    } else {
        Write-Host "✗ ERROR: public\storage existe pero NO es un enlace simbólico válido" -ForegroundColor Red
        Write-Host "  Solución: Remove-Item 'public\storage' -Recurse -Force; php artisan storage:link" -ForegroundColor Yellow
    }
} else {
    Write-Host "✗ ERROR: No existe el enlace simbólico public\storage" -ForegroundColor Red
    Write-Host "  Ejecuta: php artisan storage:link" -ForegroundColor Yellow
}

Write-Host ""

# Verificar que existe storage/app/public
if (Test-Path "storage\app\public") {
    Write-Host "✓ Directorio storage\app\public existe" -ForegroundColor Green
} else {
    Write-Host "✗ ERROR: No existe el directorio storage\app\public" -ForegroundColor Red
    Write-Host "  Ejecuta: New-Item -ItemType Directory -Path 'storage\app\public' -Force" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "Verificación completada" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
