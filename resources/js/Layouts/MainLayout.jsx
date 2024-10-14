import Navbar from "@/Pages/Navbar";
import { useEffect } from "react";
import { ToastContainer, toast } from "react-toastify"; 
import "react-toastify/dist/ReactToastify.css"; 

export default function MainLayout({ auth, children }) {
    
    const webSocketChannel = `video.shared`;
    const connectWebSocket = () => {
        Echo.private(webSocketChannel)
        .error((error) => {
            console.error(`Error subscribing to ${webSocketChannel}:`, error);
        })
            .listen('UserShareVideoEvent', async (e) => {
                console.log(e);
                toast.success(
                 <div>
                 {e.userName} has just shared <strong>{e.videoTitle}</strong>
                </div>, 
                    {
                    position: "top-right", 
                    autoClose: 5000, 
                    hideProgressBar: false, 
                    closeOnClick: true, 
                    pauseOnHover: true, 
                    draggable: true, 
                    progress: undefined, 
                });
                return () => {
                    channel.stopListening('UserShareVideoEvent');
                };
            });
    }
    useEffect(() => {
        const cleanup = connectWebSocket();
        return cleanup; 
    }, []);

    return (
        <div className="container mx-auto p-4">
             <Navbar auth={auth} />
            <div className="mt-6">
                {children}
            </div>
            <ToastContainer />
        </div>
    );
}
