# 🚀 Quick Reference - Fallos Multimedia

**Guía rápida de los 14 fallos identificados**

---

## 1️⃣ Path Traversal 🔴
- **Ubicación:** MediaContentController
- **Problema:** `file_path` sin validación de ruta
- **Riesgo:** Acceso a `../../.env`
- **Fix:** Validar con `starts_with:media/` y `not_regex:/\.\.\//`

## 2️⃣ Sin Validación de Existencia 🔴
- **Ubicación:** CustomContentController
- **Problema:** Guardar referencias sin verificar archivo existe
- **Riesgo:** URLs 404 rotas
- **Fix:** `Storage::exists($filePath)` antes de guardar

## 3️⃣ MIME Type Spoofing 🟠
- **Ubicación:** MediaService::validateMimeType()
- **Problema:** Validar MIME del cliente, no MIME real
- **Riesgo:** Subir `shell.php` como `shell.php.jpg`
- **Fix:** Usar `finfo_file()` para MIME real

## 4️⃣ Sin Sanitización de Nombres 🟠
- **Ubicación:** MediaService::generateFileName()
- **Problema:** Nombres con caracteres especiales
- **Riesgo:** `nombre;rm -rf .jpg` ejecuta comandos
- **Fix:** Limpiar con `preg_replace()` y generar UUID

## 5️⃣ Sin Cascada de Eliminación 🔴
- **Ubicación:** MediaContentController::delete()
- **Problema:** Solo elimina archivo, no referencias en BD
- **Riesgo:** Huérfanos en custom_contents
- **Fix:** `CustomContent::where('value', $filePath)->delete()`

## 6️⃣ Helper sin Validación 🟠
- **Ubicación:** app/Helpers/helpers.php
- **Problema:** `getCustomContent()` retorna ruta sin verificar existencia
- **Riesgo:** Referencias a archivos eliminados
- **Fix:** Llamar `$content->fileExists()` antes de retornar

## 7️⃣ Sin Validar Tipo Contenido 🟠
- **Ubicación:** Vista de ofertas
- **Problema:** No validar que el valor es ruta de archivo válida
- **Riesgo:** XSS potencial o URLs inválidas
- **Fix:** Usar helpers mejorados que validan

## 8️⃣ N+1 Queries 🟡
- **Ubicación:** PublicOfertaController::index()
- **Problema:** Loop de ofertas hace query por cada `custom()`
- **Riesgo:** 31 queries en lugar de 2
- **Fix:** Eager load con `.with('customContents')`

## 9️⃣ Sin Caché 🟡
- **Ubicación:** loadExistingFiles() JavaScript
- **Problema:** Fetch sin caché header
- **Riesgo:** Recarga lista de archivos cada vez
- **Fix:** Usar `sessionStorage` o cache HTTP headers

## 🔟 Lazy Loading Incompleto 🟡
- **Ubicación:** resources/views/layouts/public.blade.php
- **Problema:** Lazy load sin skeleton, blur-up, error handling
- **Riesgo:** Mala UX, sin feedback visual
- **Fix:** Agregar placeholders y error states

## 1️⃣1️⃣ Sin Límites Almacenamiento 🟠
- **Ubicación:** MediaService::processUpload()
- **Problema:** Solo validar tamaño individual, no total
- **Riesgo:** Usuario satura disco con 1000 archivos
- **Fix:** Implementar cuotas por usuario/categoría

## 1️⃣2️⃣ Sin Versionado 🟡
- **Ubicación:** CustomContent model
- **Problema:** Sin historial de cambios
- **Riesgo:** Imposible recuperar versiones anteriores
- **Fix:** Crear tabla `custom_content_history`

## 1️⃣3️⃣ Confirmación Débil 🟠
- **Ubicación:** resources/views/layouts/public.blade.php
- **Problema:** Solo `confirm()` del navegador
- **Riesgo:** Eliminación sin confirmación visual fuerte
- **Fix:** Modal de confirmación mejorado

## 1️⃣4️⃣ Sin Metadatos Completos 🟡
- **Ubicación:** CustomContent model
- **Problema:** No hay campos para alt_text, title, etc
- **Riesgo:** Accesibilidad pobre
- **Fix:** Agregar columnas + campos JSON metadata

---

## ⚡ Fixes por Prioridad

### 🔴 HOJE (Máximo 3 horas)
1. Path Traversal validation ⚠️
2. File existence check ⚠️
3. Cascading delete ⚠️

### 🟠 ESTA SEMANA (5 horas)
4. MIME type real validation
5. File name sanitization
6. Helper validation
7. N+1 query fix

### 🟡 PRÓXIMO SPRINT (4 horas)
8. Storage limits
9. Caching implementation
10. Lazy loading enhancement
11. File versioning
12. Complete metadata
13. Better confirmations

---

## 🔧 Archivos a Modificar

```
app/Http/Controllers/Public/
  ├── MediaContentController.php      ← #1, #2, #3, #4, #5, #7
  └── CustomContentController.php     ← #2, #6

app/Services/
  └── MediaService.php               ← #3, #4, #11

app/Models/
  ├── CustomContent.php              ← #6, #14
  └── Oferta.php                     ← #8

app/Helpers/
  └── helpers.php                    ← #2, #6

app/Http/Controllers/Public/
  └── PublicOfertaController.php      ← #8

resources/views/
  ├── layouts/public.blade.php        ← #9, #10, #13
  └── public/ofertas/index.blade.php  ← #2, #6, #8

database/migrations/
  └── 2026_01_27_add_multimedia_fields.php  ← #14
```

---

## ✅ Testing Quick Check

```bash
# Test 1: Path Traversal
POST /public/content/store
{"file_path": "../../../../.env"}
✅ Debe rechazar con 422

# Test 2: Missing File
POST /public/media/store
{"file_path": "media/ofertas/nonexistent.jpg"}
✅ Debe rechazar con 422

# Test 3: Query Count
GET /public/ofertas?limit=10
✅ Máximo 5 queries (en lugar de 31)

# Test 4: Cascading Delete
DELETE /public/media/delete
{"file_path": "media/ofertas/test.jpg"}
✅ Debe eliminar referencias en BD
```

---

## 📊 Métricas de Éxito

| Métrica | Antes | Después |
|---------|-------|---------|
| Path Traversal rechazados | 0% | 100% ✅ |
| URLs rotas | 30%+ | 0% ✅ |
| Queries N+1 | 31 | 2-3 ✅ |
| Archivos huérfanos | Sí | No ✅ |
| Cargas sin validación | 100% | 0% ✅ |

---

## 🎯 Rollout Plan

```
Lunes (CRÍTICOS):
├── 09:00 - Code review de fixes
├── 10:00 - Deploy a staging
├── 11:00 - QA testing
└── 14:00 - Deploy a producción

Martes-Jueves (MEDIOS):
├── Implementar fixes medios
├── Testing
└── Monitoreo

Próximo Sprint (MENORES):
├── Versionado
├── Metadata
└── Performance
```

---

## 🚨 Signos de Alerta

- ❌ Imágenes muestran 404 → Problema #2 o #6
- ❌ Referencias en BD después de eliminar → Problema #5
- ❌ Usuario sube archivo PHP → Problema #3 o #4
- ❌ Página ofertas lenta → Problema #8
- ❌ Sin confirmación al eliminar → Problema #13

---

## 📞 Questions?

Ver documentación completa:
- [FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md](FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md)
- [SOLUCIONES_MULTIMEDIA.md](SOLUCIONES_MULTIMEDIA.md)
- [TESTING_MULTIMEDIA.md](TESTING_MULTIMEDIA.md)

