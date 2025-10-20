import { usePage } from "@inertiajs/vue3"

export function useCan() {
    const page = usePage();
    const isSuperAdmin = page.props.isSuperAdmin || false;
    const adminCan = page.props.adminCan || [];

    const can = (permissions) => {
        if (isSuperAdmin) {
            return true;
        }

        if (Array.isArray(permissions)) {
            return permissions.some(permission => adminCan.includes(permission));
        } else {
            return adminCan.includes(permissions);
        }
    }

    return { can };
}

export default {
    admin_route_name: import.meta.env.VITE_ADMIN_ROUTE_NAME,
    app_name: import.meta.env.VITE_APP_NAME,
    useCan,
}