const baseUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000';

const getHeaders = () => {
  return {
    'Content-Type': 'application/json',
  };
}

const request = (endpoint, options) => {
  let url;

  if (!endpoint.startsWith('http') && !endpoint.startsWith('https')) {
    if (endpoint.startsWith('/')) {
      url = `${baseUrl}${endpoint}`;
    } else {
      url = `${baseUrl}/${endpoint}`;
    }
  }

  return fetch(url, options)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .catch((error) => {
      console.error('Error fetching:', error);
      throw error;
    }
  );
}

class ApiService {
  get(endpoint) {
    return request(endpoint);
  }

  post(endpoint, data) {
    return request(endpoint, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(data),
    });
  }

  put(endpoint, data) {
    return request(endpoint, {
      method: 'PUT',
      headers: getHeaders(),
      body: JSON.stringify(data),
    });
  }

  delete(endpoint) {
    return request(endpoint, {
      method: 'DELETE',
      headers: getHeaders(),
    });
  }
}

export const api = new ApiService();
