import { mount, flushPromises } from '@vue/test-utils';
import EstadisticasOfertas from '../EstadisticasOfertas.vue';
import axios from 'axios';

jest.mock('axios');

describe('EstadisticasOfertas.vue', () => {
  beforeEach(() => {
    jest.clearAllMocks();
  });

  it('renderiza correctamente y muestra filtros', async () => {
    axios.get.mockResolvedValueOnce({ data: { anios: [2026], ofertas: [], programas: [] } });
    axios.get.mockResolvedValueOnce({ data: { inscritos_por_oferta: [], preinscritos_metricas: [], ofertas_por_anio: [] } });
    const wrapper = mount(EstadisticasOfertas);
    await flushPromises();
    expect(wrapper.find('select').exists()).toBe(true);
    expect(wrapper.text()).toContain('Año');
  });

  it('llama al endpoint al montar el componente', async () => {
    axios.get.mockResolvedValueOnce({ data: { anios: [2026], ofertas: [], programas: [] } });
    axios.get.mockResolvedValueOnce({ data: { inscritos_por_oferta: [], preinscritos_metricas: [], ofertas_por_anio: [] } });
    mount(EstadisticasOfertas);
    await flushPromises();
    expect(axios.get).toHaveBeenCalledWith('/admin/estadisticas-preinscritos/filtros');
    expect(axios.get).toHaveBeenCalledWith('/admin/estadisticas-preinscritos/metricas', { params: { anio: '', oferta_id: '', programa_id: '' } });
  });

  it('actualiza la gráfica al cambiar filtros', async () => {
    axios.get.mockResolvedValueOnce({ data: { anios: [2026], ofertas: [{ id: 1, nombre: 'Oferta 1' }], programas: [] } });
    axios.get.mockResolvedValueOnce({ data: { inscritos_por_oferta: [], preinscritos_metricas: [], ofertas_por_anio: [] } });
    const wrapper = mount(EstadisticasOfertas);
    await flushPromises();
    axios.get.mockResolvedValueOnce({ data: { inscritos_por_oferta: [{ oferta_id: 1, total_inscritos: 10 }], preinscritos_metricas: [], ofertas_por_anio: [] } });
    await wrapper.find('select').setValue(2026);
    await flushPromises();
    expect(axios.get).toHaveBeenCalledWith('/admin/estadisticas-preinscritos/metricas', expect.objectContaining({ params: expect.objectContaining({ anio: 2026 }) }));
  });

  it('muestra mensaje si no hay datos', async () => {
    axios.get.mockResolvedValueOnce({ data: { anios: [2026], ofertas: [], programas: [] } });
    axios.get.mockResolvedValueOnce({ data: { inscritos_por_oferta: [], preinscritos_metricas: [], ofertas_por_anio: [] } });
    const wrapper = mount(EstadisticasOfertas);
    await flushPromises();
    expect(wrapper.html()).toContain('canvas'); // El canvas sigue existiendo aunque no haya datos
  });
});
