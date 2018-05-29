import Axios from 'axios'

// 设置请求超时
Axios.defaults.timeout = 20000

// 生产环境和发布环境给出不同的接口地址
Axios.defaults.baseURL = process.env.NODE_ENV === 'production' ? '' : '/api'

// 添加请求拦截器
Axios.interceptors.request.use(config => {
  return config
}, error => {
  return Promise.reject(error)
})

// 添加响应拦截器
Axios.interceptors.response.use(response => {
  return {
    data: response.data,
    status: response.status,
    statusText: response.statusText,
    header: response.headers
  }
}, error => {
  return Promise.reject(error)
})

export default Axios
