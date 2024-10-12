import VideoList from './YoutubeVideo/Partials/VideoList';
import Navbar from './Navbar';

export default function Home({ auth }) {
   
    return (
        <div className="container mx-auto p-4">
        <Navbar auth={auth}/>
       <VideoList/>
       </div>
    );
}
