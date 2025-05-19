import productsRoutes from '@/pages/products/router/index.js'
import categoriesRoutes from '@/pages/categories/router/index.js'
import movementsRoutes from '@/pages/kardex/router/index.js'

export default [...productsRoutes, ...categoriesRoutes, ...movementsRoutes]
