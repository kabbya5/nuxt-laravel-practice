type CustomFetchOptions = {
  headers?: Record<string, string>;
  method?: 'GET' | 'POST' | 'PATCH' | 'DELETE';
  body?: any;
  query?: Record<string, any>;
};

export const useApiFetch = async (url: string, options: CustomFetchOptions = {}) => {
  const config = useRuntimeConfig();

  try {
    const isFormData = options.body instanceof FormData;

    return await $fetch(url, {
      baseURL: `${config.public.baseURL}/api`,
      method: options.method || 'GET',
      headers: {
        ...options.headers,
        ...(isFormData ? {} : { 'Content-Type': 'application/json' }),
        Accept: 'application/json',
      },
      body: options.body,
      query: options.query,
      credentials:'include',
    });
  } catch (err: any) {
    throw err;
  }
};