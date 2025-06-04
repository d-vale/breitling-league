const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const defaultHeaders = {
  'Content-Type': 'application/json',
  'X-Requested-With': 'XmlHttpRequest',
  'Accept': 'application/json',
  'X-CSRF-TOKEN': csrfToken
};

let defaultBaseUrl = '';

/**
 * Update the default headers
 * @param {Object} headers - Headers to merge with the defaults for all requests
 */
export function setDefaultHeaders(headers) {
  Object.assign(defaultHeaders, headers);
}

/**
 * Set the default base URL
 * @param {string} url - Base URL to use for all requests
 */
export function setDefaultBaseUrl(url) {
  if (url[url.length - 1] === '/') url = url.slice(0, -1);
  defaultBaseUrl = url;
}

/**
 * Perform an HTTP request with JSON support, timeout, and error handling
 *
 * @param {Object|string} options - Either a configuration object with request parameters, or a URL string (in which case defaults are applied to other parameters)
 * @param {string} options.url - Relative request URL (required)
 * @param {Object|null} [options.data=null] - Data to send (body or query string)
 * @param {string|null} [options.method=null] - HTTP method (GET, POST, etc.)
 * @param {Object} [options.headers={}] - Additional headers
 * @param {number} [options.timeout=5000] - Timeout in milliseconds
 * @param {string|null} [options.baseUrl=null] - Custom base URL for this request
 * @returns {Object} - { request: Promise, abort: Function }
 */
export function fetchJson(options) {
  if (typeof options === 'string') {
    options = { url: options };
  }

  const {
    url,
    data = null,
    method = null,
    headers = {},
    timeout = 5000,
    baseUrl = '',
  } = options;

  if (typeof url !== 'string') throw new Error('The URL must be a string.');
  const theMethod = method ? method.toUpperCase() : (data ? 'POST' : 'GET');

  let fullUrl;
  if (url.startsWith('http://') || url.startsWith('https://')) {
    fullUrl = url;
  } else {
    fullUrl = (baseUrl ?? defaultBaseUrl) + (url.startsWith('/') ? url : '/' + url);
  }

  if (theMethod === 'GET' && data) {
    const queryString = new URLSearchParams(data).toString();
    fullUrl += '?' + queryString;
  }

  const allHeaders = { ...defaultHeaders, ...headers };

  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), timeout);
  const signal = controller.signal;

  const body = theMethod !== 'GET' && data ? JSON.stringify(data) : null;

  const request = new Promise((resolve, reject) => {
    fetch(fullUrl, { method: theMethod, headers: allHeaders, body, signal })
      .then(resp => {
        clearTimeout(timeoutId);
        const respClone = resp.clone();
        return resp.json()
          .then(data => {
            if (!resp.ok) {
              reject({ status: resp.status, statusText: resp.statusText, data });
            } else {
              resolve(data);
            }
          })
          .catch(() => {
            return respClone.text()
              .then(() => reject({
                status: resp.status,
                statusText: 'Error parsing response body as JSON',
                data: null,
              }))
              .catch(() => reject({
                  status: resp.status,
                  statusText: 'Error parsing response body',
                  data: null,
              }));
          });
      })
      .catch(err => {
        clearTimeout(timeoutId);
        if (err.name === 'AbortError') {
          reject({ status: 0, statusText: 'Request aborted (timeout)', data: null });
        } else {
          reject({ status: 0, statusText: err.message || 'Network error', data: null });
        }
      });
  });

  return {
    request,
    abort: () => controller.abort(),
  };
}