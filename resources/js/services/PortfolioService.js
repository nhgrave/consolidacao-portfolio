import { api } from './ApiService';

export function fetchPortFolio({ clientId } = {}) {
  return api.get(`/api/v1/portfolio/${clientId}`);
}

export function generateReport({ clientId } = {}) {
  return api.post(`/api/v1/portfolio/${clientId}/report`);
}

export function fetchReportStatus({ clientId } = {}) {
  return api.get(`/api/v1/portfolio/${clientId}/report_status`);
}
