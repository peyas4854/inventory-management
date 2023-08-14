const BackEndRoutes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('./pages/Dashboard'),
        meta     : {
            title: 'Dashboard',
        }
    },
    {
        path: '/product',
        name: 'product',
        component: () => import('./pages/product/index'),
        meta     : {
            title: 'Product List',
        }
    },
    {
        path: '/product/create',
        name: 'productCreate',
        component: () => import('./pages/product/create'),
        meta     : {
            title: 'Product Create',
        }
    },
    {
        path: '/product/edit/:id',
        name: 'productEdit',
        component: () => import('./pages/product/create'),
        meta     : {
            title: 'Product Edit',
        }
    },
    {
        path: '/invoice',
        name: 'invoice',
        component: () => import('./pages/invoice/index'),
        meta     : {
            title: 'Invoice List',
        }
    },
    {
        path: '/invoice/create',
        name: 'invoiceCreate',
        component: () => import('./pages/invoice/create'),
        meta     : {
            title: 'Invoice Create',
        }
    },

]



export default BackEndRoutes;
