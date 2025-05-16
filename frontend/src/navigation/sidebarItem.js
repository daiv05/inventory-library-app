import IconHomeAccount from '~icons/mdi/home-account'
import IconBookCogOutline from '~icons/mdi/book-cog-outline'
import IconShapePlusOutline from '~icons/mdi/shape-plus-outline'
import IconSitemap from '~icons/mdi/sitemap'

const sidebarItem = [
  {
    title: 'Inicio',
    icon: IconHomeAccount,
    to: '/inicio'
  },
  { divider: true },
  { header: 'Productos' },
  {
    title: 'Listado',
    icon: IconBookCogOutline,
    to: '/productos/listado'
  },
    {
    title: 'Categorias',
    icon: IconShapePlusOutline,
    to: '/productos/categorias'
  },
  { divider: true },
  { header: 'Inventario' },
  {
    title: 'Movimientos',
    icon: IconSitemap,
    to: '/inventario/movimientos'
  }
]

export default sidebarItem
