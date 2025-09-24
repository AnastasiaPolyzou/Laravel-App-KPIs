import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Home({auth}){
    return (
         <AuthenticatedLayout user={auth.user}>
            <Head title="Home" />

            <div className="text-center mt-10">
                <h1 className="text-3xl font-bold mb-4">Welcome, {auth.user.name}!</h1>
                <p className="text-lg text-gray-700 dark:text-gray-300">
                    Choose from Menu Dashboard, KPIs or Profile to begin
                </p>
            </div>
         </AuthenticatedLayout>

    );
};