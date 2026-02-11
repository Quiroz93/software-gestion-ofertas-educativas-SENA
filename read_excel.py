#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
try:
    from xlrd import open_workbook
    
    file_path = r"c:\Users\AdminSena\Documents\SoeSoftware2\excel\FormatoInscripcionAspirantesSOFIAPlus.xls"
    
    print("=== INFORMACIÓN DEL ARCHIVO ===")
    print(f"Archivo: FormatoInscripcionAspirantesSOFIAPlus.xls\n")
    
    workbook = open_workbook(file_path)
    
    print(f"Número de hojas: {workbook.nsheets}")
    print(f"Nombres de hojas: {workbook.sheet_names()}\n")
    
    for sheet_idx, sheet_name in enumerate(workbook.sheet_names()):
        sheet = workbook.sheet_by_index(sheet_idx)
        print(f"\n--- HOJA: {sheet_name} ---")
        print(f"Dimensiones: {sheet.nrows} filas x {sheet.ncols} columnas")
        print(f"\nPrimeras 15 filas:")
        print("-" * 150)
        
        for row_idx in range(min(15, sheet.nrows)):
            row_data = []
            for col_idx in range(sheet.ncols):
                cell_value = sheet.cell_value(row_idx, col_idx)
                row_data.append(str(cell_value)[:25])
            print(" | ".join(row_data))
        
except Exception as e:
    print(f"Error: {e}", file=sys.stderr)
    import traceback
    traceback.print_exc()
