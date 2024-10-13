import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import Share from "./YoutubeVideo/Partials/Share";

export default function SharePage({ auth }) {
    return (
        <MainLayout auth={auth}>

            <Head title="Share" />

            <Share />

        </MainLayout>
    );
}