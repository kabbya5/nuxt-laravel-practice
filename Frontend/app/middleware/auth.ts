import {useAuthStore} from '~/stores/auth';

export default defineNuxtRouteMiddleware(async () => {
    const auth = useAuthStore();
    if (!auth.user) {
        try {
        await auth.initAuth()
        } catch {
        return navigateTo('/login')
        }
    }
});