import VueRouter from "vue-router";
import Dashboard from '../Pages/Client/Dashboard.vue'
import About from '../Pages/Client/About.vue'
import ComicShow from '../Pages/Client/ComicShow.vue'
import AuthorShow from '../Pages/Client/AuthorShow.vue'
import PageShow from '../Pages/Client/PageShow.vue'
import PaymentShow from '../Pages/Client/PaymentShow.vue'
import Login from '../Pages/Client/Login.vue'
import Account from '../Pages/Client/Account.vue'
import Privacy from '../Pages/Client/Privacy.vue'
import MyComic from '../Pages/Client/MyComic.vue'
import Register from '../Pages/Client/Register.vue'
import Logout from '../Pages/Client/Logout.vue'
import Search from '../Pages/Client/Search.vue'
import SceneShow from '../Pages/Client/SceneShow.vue'

import NotFound from '../Pages/NotFound.vue'

import AdminHome from '../Pages/Admin/Home.vue'
import AdminComics from '../Pages/Admin/Comics.vue'
import AdminComicNew from '../Pages/Admin/ComicNew.vue'
import AdminComicShow from '../Pages/Admin/ComicShow.vue'
import AdminLogin from '../Pages/Admin/Login.vue'
import AdminLogout from '../Pages/Admin/Logout.vue'
import AdminAppLayout from '../Layout/AdminAppLayout.vue'
import AppLayout from '../Layout/AppLayout.vue'
import store from '../Store/store'

const routes = [
    {
        path: '/',
        component: AppLayout,
        name: 'appLayout',
        children: [
            {
                path: '/',
                component: Dashboard,
                name: 'dashboard'
            },
            {
                path: '/about',
                component: About,
                name: 'about'
            },
            {
                path: '/scene/:pageId',
                component: SceneShow,
                name: 'sceneShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/search',
                component: Search,
                name: 'search',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comic/:comicId',
                component: ComicShow,
                name: 'comicShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/page/:comicId/:chapter',
                component: PageShow,
                name: 'pageShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/author/:authorId',
                component: AuthorShow,
                name: 'authorShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/payment',
                component: PaymentShow,
                name: 'paymentShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/mycomic',
                component: MyComic,
                name: 'mycomic',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/myaccount',
                component: Account,
                name: 'myaccount',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/privacy',
                component: Privacy,
                name: 'privacy',
            },
            {
                path: '/404',
                name: 'notFound',
                component: NotFound
            },
        ]
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
        meta: {
            
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
        }
    },
    {
        path: '/logout',
        component: Logout,
        name: 'logout',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin',
        component: AdminAppLayout,
        name: 'adminAppLayout',
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/home',
                component: AdminHome,
                name: 'adminHome',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comics',
                component: AdminComics,
                name: 'adminComics',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comic/:id',
                component: AdminComicShow,
                name: 'adminComicShow',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comic/new',
                component: AdminComicNew,
                name: 'adminComicNew',
                meta: {
                    requiresAuth: true
                }
            },
        ]
    },
    {
        path: '/admin/login',
        component: AdminLogin,
        name: 'adminLogin',
        meta: {
            requiresVisitor: true
        }
    },
    {
        path: '/admin/logout',
        component: AdminLogout,
        name: 'adminLogout',
        meta: {
            requiresAuth: true,
        }
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    window.scrollTo(0, 0)
    const loggedIn = localStorage.getItem("token")
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.tokenExpired || (!store.getters.loggedIn && !loggedIn)) {
            return next({
                name: 'login',
            })
        } else {
            return next()
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
            return next({
                name: 'dashboard',
            })
        } else {
            return next()
        }
    } else {
        next()
    }
});

export default router
