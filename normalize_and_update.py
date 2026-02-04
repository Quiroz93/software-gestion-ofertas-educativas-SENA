#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import re
from pathlib import Path

# Mapeo de nombres encontrados en el archivo a nombres canónicos + IDs
PROGRAMA_MAP = {
    # Procesos de Panadería (ID 1)
    'PANDERIA': ('Procesos de Panadería', 1),
    'panaderia': ('Procesos de Panadería', 1),
    'PANADERIA': ('Procesos de Panadería', 1),
    
    # Dibujo Arquitectónico - FIC (ID 2)
    'DIBUJO ARQUITECTONICO': ('Dibujo Arquitectónico - FIC', 2),
    'dibujo arquitectónico': ('Dibujo Arquitectónico - FIC', 2),
    'Dibujo Arquitectónico': ('Dibujo Arquitectónico - FIC', 2),
    'DIBUJO ARQUITECTÓNICO': ('Dibujo Arquitectónico - FIC', 2),
    'dibujo arqutectonico': ('Dibujo Arquitectónico - FIC', 2),
    'Dibujo Arquitectónico - FIC': ('Dibujo Arquitectónico - FIC', 2),
    
    # Atención Integral a la Primera Infancia (ID 3)
    'GESTION A LA PRIMERA INFANCA': ('Atención Integral a la Primera Infancia', 3),
    'Atencion integral a la primera infancia': ('Atención Integral a la Primera Infancia', 3),
    'primera infancia': ('Atención Integral a la Primera Infancia', 3),
    'Primera infancia ': ('Atención Integral a la Primera Infancia', 3),
    'Atención Integral a la Primera Infancia': ('Atención Integral a la Primera Infancia', 3),
    
    # Cosmetología y Estética Integral (ID 4)
    'COSMETOLOGIA': ('Cosmetología y Estética Integral', 4),
    'cosmetologia': ('Cosmetología y Estética Integral', 4),
    'PELUQUERIA': ('Cosmetología y Estética Integral', 4),
    'Cosmetologia': ('Cosmetología y Estética Integral', 4),
    'Cosmetología y Estetica Integral': ('Cosmetología y Estética Integral', 4),
    'Cosmetologia y estetica integral': ('Cosmetología y Estética Integral', 4),
    'Cosmetologia y estetica iontegral': ('Cosmetología y Estética Integral', 4),
    'TC.COSMETOLOGIA': ('Cosmetología y Estética Integral', 4),
    'Cosmetología y estetica integral': ('Cosmetología y Estética Integral', 4),
    
    # Ejecución de Programas Deportivos (ID 5)
    # (Actividad Física en el archivo se refiere a esto o al ID 6)
    
    # Actividad Física (ID 6)
    'ACTIVIDAD FISICA': ('Actividad Física', 6),
    'Actividad Física ': ('Actividad Física', 6),
    'Actividad Física': ('Actividad Física', 6),
    'actividad fisica': ('Actividad Física', 6),
    'Actividad fisica': ('Actividad Física', 6),
    'Acttividad Fisica': ('Actividad Física', 6),
    
    # Gestión Administrativa (ID 7)
    'GESTION ADMINISTRATIVA': ('Gestión Administrativa', 7),
    'gestion administrativa': ('Gestión Administrativa', 7),
    'Gestion Administrativa': ('Gestión Administrativa', 7),
    'GEstion administrativa': ('Gestión Administrativa', 7),
    'getion administrativa': ('Gestión Administrativa', 7),
    'gestion Administrativa': ('Gestión Administrativa', 7),
    'GESTION EMPRESARIAL': ('Gestión Administrativa', 7),
    'Gestion Administrativa': ('Gestión Administrativa', 7),
    'administracion de empresas': ('Gestión Administrativa', 7),
    'GESTION EMPRESARIAL/ MECANICA': ('Gestión Administrativa', 7),
    
    # Análisis y Desarrollo de Software (ID 8)
    'ADSO': ('Análisis y Desarrollo de Software', 8),
    'Analisis Y Diseño De Software': ('Análisis y Desarrollo de Software', 8),
    'analisis y desarrollo de software': ('Análisis y Desarrollo de Software', 8),
    'ADSO': ('Análisis y Desarrollo de Software', 8),
    
    # Mantenimiento de motos y motocarros (ID 10)
    'MANTENIMIENTO DE MOTOS Y MOTOCARROS': ('Mantenimiento de motos y motocarros', 10),
    'MANTENIMIENTOS DE MOTOS Y MOTOCARROS': ('Mantenimiento de motos y motocarros', 10),
    
    # Enfermería (ID 13)
    'ENFERMERIA': ('Enfermería', 13),
    'Enfermería': ('Enfermería', 13),
    'ENERMERIA': ('Enfermería', 13),
    
    # Procesamiento de carnes (ID 15)
    'PROCESAMIENTO DE CARNES': ('Procesamiento de carnes', 15),
    
    # Producción ganadera (ID 16)
    'produccion ganadera': ('Producción ganadera', 16),
    
    # Gestión de la Producción Agrícola (ID 18)
    'GESTION DE LA PRODUCCION AGRICOLA': ('Gestión de la Producción Agrícola', 18),
    
    # Construcción en edificaciones (ID 19)
    'CONSTRUCCION EN EDIFICACIONES': ('Construcción en edificaciones', 19),
    'costruccion': ('Construcción en edificaciones', 19),
    'construccion/electricidad': ('Construcción en edificaciones', 19),
    'constuccio': ('Construcción en edificaciones', 19),
    
    # Cocina (ID 20)
    'COCINA': ('Cocina', 20),
    
    # Topografía (ID 21)
    'TOPOGRAFIA': ('Topografía', 21),
    'topgrafia': ('Topografía', 21),
    'Topografía': ('Topografía', 21),
    'topografia ': ('Topografía', 21),
    'topografia': ('Topografía', 21),
    'topgrafia': ('Topografía', 21),
    'Topogrfía': ('Topografía', 21),
    'Tpogafía': ('Topografía', 21),
    'levantamiento topografico': ('Topografía', 21),
    
    # Cultivos agrícolas (ID 35)
    'CULTIVOS AGRICOLAS': ('Cultivos agrícolas', 35),
    
    # Salud Ocupacional (ID 36)
    'SALUD OCUPACIONAL': ('Salud Ocupacional', 36),
    
    # Inglés (ID 38)
    'INGLES': ('Inglés', 38),
    
    # Gestión Contable y de Información Financiera (ID 24)
    'GESTION CONTABLE Y DE INFORMACION FINANCIERA': ('Gestión Contable y de Información Financiera', 24),
    'GESTION CONTABLE': ('Gestión Contable y de Información Financiera', 24),
    'Gestion Contable': ('Gestión Contable y de Información Financiera', 24),
    'gestion contable': ('Gestión Contable y de Información Financiera', 24),
    'Gestion Contable': ('Gestión Contable y de Información Financiera', 24),
    'CONTABILIDAD': ('Gestión Contable y de Información Financiera', 24),
    'Contabilidad': ('Gestión Contable y de Información Financiera', 24),
    'contabilidad': ('Gestión Contable y de Información Financiera', 24),
    'contabilidad Virtual': ('Gestión Contable y de Información Financiera', 24),
    'contabilidad -Virtual': ('Gestión Contable y de Información Financiera', 24),
    'contabilidad ': ('Gestión Contable y de Información Financiera', 24),
    
    # Coordinación de sistemas integrados de gestión (ID 23)
    'COORDINACION DE SISTEMAS INTEGRADOS Y DE GESTION': ('Coordinación de sistemas integrados de gestión', 23),
    'coordinacion de sistemas integrados de gestion': ('Coordinación de sistemas integrados de gestión', 23),
    'coordinacion en sistemas integrados de gestion': ('Coordinación de sistemas integrados de gestión', 23),
    'coordinacion de sistemas': ('Coordinación de sistemas integrados de gestión', 23),
    
    # Cuidador (ID 22)
    'CURSO DE CUIDADOR': ('Cuidador', 22),
    
    # Sin asignación
    'N/A': ('N/A', 33),
    'SISTEMAS': ('Sistemas', 32),
}

def normalize_programa(programa):
    """Busca el nombre exacto en el mapa y retorna tupla (nombre_canonico, id)"""
    programa_cleaned = programa.strip()
    
    if programa_cleaned in PROGRAMA_MAP:
        return PROGRAMA_MAP[programa_cleaned]
    
    # Si no encuentra exacto, retorna el programa original con ID 0
    return (programa_cleaned, 0)

def process_file():
    file_path = Path('c:/Users/AdminSena/Documents/SoeSoftware2/base_datos_preinscritos.md')
    
    with open(file_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    
    result_lines = []
    header_processed = False
    
    for idx, line in enumerate(lines):
        if idx == 0:
            # Procesar header - agregar columna numero_ficha
            parts = line.rstrip('\n').split('\t')
            # Buscar posición de 'programa'
            if 'programa' in parts:
                prog_idx = parts.index('programa')
                # Insertar numero_ficha después de programa
                parts.insert(prog_idx + 1, 'numero_ficha')
            header_line = '\t'.join(parts)
            result_lines.append(header_line + '\n')
            header_processed = True
        else:
            # Procesar líneas de datos
            line_clean = line.rstrip('\n')
            
            # Skip lineas vacías
            if not line_clean.strip():
                result_lines.append(line)
                continue
            
            parts = line_clean.split('\t')
            
            # Verificar que tenga suficientes columnas
            if len(parts) < 5:
                result_lines.append(line)
                continue
            
            # El programa está en posición 4 (0-indexed)
            programa_original = parts[4].strip()
            
            if programa_original:
                nombre_canonico, programa_id = normalize_programa(programa_original)
                
                # Reemplazar nombre original con canónico
                parts[4] = nombre_canonico
                
                # Insertar el ID en la posición 5
                if len(parts) <= 5:
                    # Si no hay suficientes columnas, agregar las que falten
                    while len(parts) < 6:
                        parts.append('')
                
                parts.insert(5, str(programa_id))
            else:
                # Si programa está vacío
                if len(parts) <= 5:
                    while len(parts) < 6:
                        parts.append('')
                parts.insert(5, '0')
            
            new_line = '\t'.join(parts)
            result_lines.append(new_line + '\n')
    
    # Escribir resultado
    with open(file_path, 'w', encoding='utf-8') as f:
        f.writelines(result_lines)
    
    print(f"✅ Archivo procesado: {len(result_lines)} líneas")
    print(f"   - Header actualizado con columna numero_ficha")
    print(f"   - Programas normalizados: {len(result_lines) - 1} registros")

if __name__ == '__main__':
    process_file()
