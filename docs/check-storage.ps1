# Script de verificacion del enlace simbolico de storage
# Autor: Sistema de Gestion de Ofertas Educativas SENA
# Fecha: 2026-01-28

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "Verificacion de Storage Link" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

# Verificar si existe public/storage
if (Test-Path "public\storage") {
    $link = Get-Item "public\storage"
    
    # Verificar si es un enlace simbolico o junction valido
    if (($link.LinkType -eq "SymbolicLink" -or $link.LinkType -eq "Junction") -and $link.Target) {
        $linkTypeDesc = if ($link.LinkType -eq "Junction") { "Junction Point" } else { "Symbolic Link" }
        Write-Host "OK: $linkTypeDesc existe: public\storage -> $($link.Target)" -ForegroundColor Green
        
        # Verificar que el directorio de destino existe
        if (Test-Path $link.Target[0]) {
            Write-Host "OK: Directorio de destino valido: $($link.Target[0])" -ForegroundColor Green
        } else {
            Write-Host "ERROR: El directorio de destino NO existe: $($link.Target[0])" -ForegroundColor Red
            Write-Host "Ejecuta: php artisan storage:link" -ForegroundColor Yellow
        }
    } else {
        Write-Host "ERROR: public\storage existe pero NO es un enlace simbolico valido" -ForegroundColor Red
        Write-Host "Solucion: Remove-Item 'public\storage' -Recurse -Force; php artisan storage:link" -ForegroundColor Yellow
    }
}
else {
    Write-Host "ERROR: No existe el enlace simbolico public\storage" -ForegroundColor Red
    Write-Host "Ejecuta: php artisan storage:link" -ForegroundColor Yellow
}

Write-Host ""

# Verificar que existe storage/app/public
if (Test-Path "storage\app\public") {
    Write-Host "OK: Directorio storage\app\public existe" -ForegroundColor Green
}
else {
    Write-Host "ERROR: No existe el directorio storage\app\public" -ForegroundColor Red
    Write-Host "Ejecuta: New-Item -ItemType Directory -Path 'storage\app\public' -Force" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "Verificacion completada" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
