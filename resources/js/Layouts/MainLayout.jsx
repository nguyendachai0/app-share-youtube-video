import Navbar from "@/Pages/Navbar";

export default function MainLayout({ auth, children }) {
    return (
        <div className="container mx-auto p-4">
             <Navbar auth={auth} />
            <div className="mt-6">
                {children}
            </div>
        </div>
    );
}
