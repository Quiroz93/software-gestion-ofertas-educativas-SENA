# Instrucciones de Build - Proyecto SENA

## Requisitos Previos

1. **Node.js 20.x LTS o superior**
   - Descargar: https://nodejs.org/en/download/
   - Verificar instalación: `node --version`

2. **NPM (incluido con Node.js)**
   - Verificar instalación: `npm --version`

## Instalación de Dependencias

```powershell
# Navegar al directorio del proyecto
cd c:\Users\AdminSena\Documents\SoeSoftware2

# Instalar dependencias
npm install
```

## Comandos de Build

### Desarrollo (con hot reload)
```powershell
npm run dev
```

### Producción (minificado y optimizado)
```powershell
npm run build
```

## Verificación Post-Build

```powershell
# Ver archivos generados
Get-ChildItem "public\build\assets"

# Ver tamaños
Get-ChildItem "public\build\assets\*.css" | Select-Object Name, @{Name="KB";Expression={[math]::Round($_.Length / 1KB, 2)}}
Get-ChildItem "public\build\assets\*.js" | Select-Object Name, @{Name="KB";Expression={[math]::Round($_.Length / 1KB, 2)}}

# Ver manifest
Get-Content "public\build\manifest.json" | ConvertFrom-Json
```

## Testing Local

```powershell
# Iniciar servidor Laravel
php artisan serve

# Abrir en navegador: http://localhost:8000
```

## Estructura CSS

El proyecto usa una arquitectura modular:

```
resources/css/
├── app.css (punto de entrada)
├── tokens/ (variables SENA)
├── base/ (reset, tipografía, formularios)
├── components/ (botones, cards, badges, alerts, forms, navegación, hero)
├── layouts/ (admin, public, auth)
└── pages/ (home)
```

Todos los archivos se importan desde `app.css` y se compilan en un solo archivo minificado.

## Notas Importantes

- ✅ `vite.config.js` ya está configurado correctamente
- ✅ Solo `app.css` se compila (incluye todos los @imports)
- ✅ Minificación automática habilitada (terser)
- ✅ Bootstrap separado en vendor chunk
- ✅ Console.log removidos en producción
