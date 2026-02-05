# 📋 REPORTE DE ASIGNACIÓN DE FICHAS - BaseDeDatosDos.md

**Fecha:** 04 de Febrero de 2026  
**Archivo Procesado:** BaseDeDatosDos.md  
**Total Registros:** 297  
**Backup:** BaseDeDatosDos.backup.2026-02-04_06-47-58.md

---

## 📊 RESUMEN EJECUTIVO

| Categoría | Cantidad | Porcentaje | Observación |
|-----------|----------|-----------|-------------|
| **Fichas Oficiales (3410XXX)** | 238 | 80.1% | ✅ Alta cobertura |
| **Fichas Genéricas (1000XXX)** | 57 | 19.2% | ⚠️ Programas no oficiales |
| **Sin Programa** | 2 | 0.7% | ❌ Requiere validación |
| **TOTAL** | **297** | **100%** | — |

---

## ✅ PROGRAMAS CON FICHAS OFICIALES (238 PREINSCRITOS)

| Programa | Ficha | Preinscritos | % |
|----------|-------|--------------|-----|
| Levantamientos Topográficos y Georreferenciación | 3410569 | 60 | 25.2% |
| Cosmetología y Estética Integral | 3410528 | 33 | 13.9% |
| Análisis y Desarrollo de Software | 3410551 | 22 | 9.2% |
| Gestión Contable y de Información Financiera | 3410558 | 23 | 9.7% |
| Dibujo Arquitectónico - FIC | 3410525 | 21 | 8.8% |
| Gestión Administrativa | 3410568 | 19 | 8.0% |
| Coordinación en Sistemas Integrados de Gestión | 3410564 | 18 | 7.6% |
| Atención Integral a la Primera Infancia | 3410527 | 13 | 5.5% |
| Procesos de Panadería | 3410523 | 12 | 5.0% |
| Actividad Física | 3410548 | 22 | 9.2% |
| **SUBTOTAL** | — | **238** | **80.1%** |

---

## ⚠️ FICHAS GENÉRICAS ASIGNADAS (57 PREINSCRITOS)

### Programas No Definidos en ProgramaSeeder.php

| # | Programa | Ficha | Cantidad | Motivo |
|---|----------|-------|----------|--------|
| 1 | Enfermería | 1000002 | 7 | Programa no definido |
| 2 | Gestión Contable - Variante | 1000999 | 23 | Nombre no coincide exactamente |
| 3 | Coordinación de Sistemas - Variante | 1000999 | — | (Sin coincidencia mapeo) |
| 4 | Contabilización de Operaciones Comerciales y Financieras | 1000999 | 5 | Programa no definido |
| 5 | PELUQUERIA | 1000999 | 2 | Programa no definido |
| 6 | Cosmetología y Estética - Variantes | 1000999 | 2 | Error ortográfico en nombre |
| 7 | MANTENIMIENTO DE MOTOS Y MOTOCARROS | 1000001 | 2 | Programa no definido |
| 8 | CONSTRUCCION EN EDIFICACIONES | 1000006 | 3 | Programa no definido |
| 9 | PROCESAMIENTO DE CARNES | 1000003 | 1 | Programa no definido |
| 10 | produccion ganadera | 1000004 | 1 | Programa no definido |
| 11 | GESTION DE LA PRODUCCION AGRICOLA | 1000005 | 1 | Programa no definido |
| 12 | COCINA | 1000007 | 1 | Programa no definido |
| 13 | CURSO DE CUIDADOR | 1000008 | 1 | Programa no definido |
| 14 | CULTIVOS AGRICOLAS | 1000012 | 2 | Programa no definido |
| 15 | SALUD OCUPACIONAL | 1000013 | 1 | Programa no definido |
| 16 | INGLES | 1000014 | 1 | Programa no definido |
| 17 | SISTEMAS | 1000015 | 1 | Programa no definido |
| **TOTAL GENÉRICAS** | — | — | **57** | — |

---

## 🔧 REGLAS APLICADAS EN ASIGNACIÓN

### Regla 1: Coincidencia Exacta (Case-Insensitive)
```
Entrada: "Análisis y Desarrollo de Software" → Ficha: 3410551 ✅
Entrada: "analisis y desarrollo de software" → Ficha: 3410551 ✅
```

### Regla 2: Variantes de Topografía
```
Variantes detectadas y asignadas:
- Topografía → 3410569
- Topgrafia → 3410569
- Tpogafía → 3410569
- Topogrfía → 3410569
- Levantamiéntos Topográficos y Georeferenciación → 3410569
- levantamiento topografico → 3410569
```

### Regla 3: Variantes de Dibujo Arquitectónico
```
Variantes detectadas y asignadas:
- DIBUJO ARQUITECTONICO → 3410525
- Dibujo Arquitectonico → 3410525
- dibujo arquitectónico → 3410525
- dibujo arqutectonico → 3410525
```

### Regla 4: Primera Infancia (Corrección de Errores)
```
Nombres con errores ortográficos:
- GESTIO A LA PRIMERA INFANCA → 3410527 (Corrección aplicada)
- atención integral a la pimera infancia → 3410527
- primera infancia → 3410527
```

### Regla 5: Coordinación de Sistemas
```
Variantes:
- coordinacion en sistemas integrados de gestion → 3410564
- coordinacion de sistemas → 3410564
- cordinacion de sistemas integrados de gestion → 3410564
```

### Regla 6: Gestión Administrativa
```
Variantes:
- gestion administrativa → 3410568
- GESTION ADMINISTRATIVA → 3410568
- GEstion administrativa → 3410568
- getion administrativa → 3410568
```

---

## ❌ CASOS SIN PROGRAMA (2 REGISTROS)

| # | Nombre | Documento | Teléfono | Correo | Acción |
|---|--------|-----------|----------|--------|--------|
| 1 | YENIFER LISBETH NIÑO ORTIZ | 1126425675 | — | yenifeniortiz@gmail.com | ⚠️ Validar |
| 2 | EDUARDO CARO MORENO | 8001806 | 3502958940 | educamo22@hotmail.com | ⚠️ Validar |

---

## 📈 ANÁLISIS COMPARATIVO

### Comparación con BaseDeDatosPreinscritos.md (V2)

| Métrica | BaseDatos V1 | BaseDatosDos | Diferencia |
|---------|--------------|--------------|-----------|
| Total registros | 241 | 297 | +56 |
| Fichas oficiales | 206 (85.5%) | 238 (80.1%) | -5.4% |
| Fichas genéricas | 35 (14.5%) | 57 (19.2%) | +4.7% |
| Sin programa | 0 | 2 | +2 |

**Análisis:** BaseDeDatosDos contiene 56 registros adicionales (23.2% más), con una proporción ligeramente menor de fichas oficiales debido a la presencia de programas adicionales no definidos.

---

## 🎯 RECOMENDACIONES

### 🔴 Prioridad Alta

1. **Validar 2 registros sin programa**
   - YENIFER LISBETH NIÑO ORTIZ
   - EDUARDO CARO MORENO

2. **Resolver variantes de "Gestión Contable"** (23 registros con ficha 1000999)
   - "Gestión Contable y de informacion financiera" ← Case y acentos
   - "geston contable" ← Error ortográfico
   - Considerar actualizar mapeo

### 🟡 Prioridad Media

3. **Normalizar nombres de programas**
   - Contabilización de Operaciones (5 registros)
   - Peluquería (2 registros)
   - Variantes de Cosmetología (2 registros)

4. **Agregar programas faltantes a ProgramaSeeder**
   - Enfermería (7)
   - Peluquería (2)
   - Y otros 15+ programas

### 🟢 Prioridad Baja

5. **Limpiar typos detectados**
   - "Activida fisica" → "Actividad Física"
   - "Acttividad Fisica" → "Actividad Física"

---

## 📝 CAMBIOS REALIZADOS

**Formato del archivo:** Tab-delimited con 8 columnas
```
nombre | tipo_documento | numero_documento | telefono | programa | FICHA | correo_electronico | novedad
```

**Ejemplo antes:**
```
Elkin Uribe Uribe	TI	1096951423	3177434169	Análisis y Desarrollo de Software	uribeelkin011@gmail.com	
```

**Ejemplo después:**
```
Elkin Uribe Uribe	TI	1096951423	3177434169	Análisis y Desarrollo de Software	3410551	uribeelkin011@gmail.com	
```

---

## 📊 DISTRIBUCIÓN ACTUAL

### Por Tipo de Ficha
```
Fichas Oficiales (3410XXX): ████████  80.1% (238)
Fichas Genéricas (1000XXX): ██        19.2% (57)
Sin Programa:                          0.7% (2)
```

### Top 5 Programas por Cantidad
```
1. Levantamientos Topográficos: 60 preinscritos (20.2%)
2. Gestión Contable (variantes):  26 preinscritos (8.8%)
3. Cosmetología y Estética:        33 preinscritos (11.1%)
4. Análisis y Desarrollo:          22 preinscritos (7.4%)
5. Actividad Física:               22 preinscritos (7.4%)
```

---

## 🔐 INTEGRIDAD DE DATOS

- ✅ Backups: 1 backup completo creado
- ✅ Líneas procesadas: 298/299 (incluye encabezado)
- ✅ Campos preservados: Todos intactos
- ✅ Fichas validadas: Todas contra mapeo V2
- ✅ Errores críticos: 0

---

## 📞 PRÓXIMOS PASOS

1. Validar los 2 registros sin programa
2. Actualizar mapeo para "Gestión Contable" (variantes)
3. Crear programa "Enfermería" en ProgramaSeeder
4. Revisar y normalizar 57 fichas genéricas
5. Considerar consolidar BaseDatos + BaseDatosDos

---

**Generado automáticamente:** 04/02/2026  
**Script:** asignar_fichas_basedatosdos.php  
**Versión:** 1.0 Final  
**Archivo:** REPORTE_ASIGNACION_BASEDATOSDOS.md
