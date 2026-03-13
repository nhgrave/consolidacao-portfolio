import { api } from './ApiService';

export function fetchPortFolio({ clientId } = {}) {
  return api.get(`/api/v1/portfolio/${clientId}`);
}
