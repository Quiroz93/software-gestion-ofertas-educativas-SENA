import xlrd

file_path = 'excel/REGIONAL SANTANDER-3410558-05-02-2026.xls'
wb = xlrd.open_workbook(file_path)
sheet = wb.sheet_by_name('Resultados')

print(f"Total rows: {sheet.nrows}")
print(f"Total columns: {sheet.ncols}\n")

# Mostrar todas las filas para encontrar headers
for row_idx in range(min(20, sheet.nrows)):
    row_data = []
    for col_idx in range(sheet.ncols):
        value = str(sheet.cell_value(row_idx, col_idx)).strip()[:40]
        row_data.append(value if value else "(empty)")
    print(f"Row {row_idx:2d}: {row_data}")
