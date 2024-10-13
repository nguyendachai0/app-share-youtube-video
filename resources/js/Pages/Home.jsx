import MainLayout from '@/Layouts/MainLayout';
import VideoList from './YoutubeVideo/Partials/VideoList';

export default function Home({ auth, videos, userLikes }) {
   
    return (
        <MainLayout auth={auth}>
            
            <VideoList videos={videos} userLikes={userLikes} />
        </MainLayout>
    );  
}
