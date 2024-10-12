import React, { useState, useEffect } from "react";
import { FaThumbsUp, FaThumbsDown } from "react-icons/fa";
// import { ToastContainer } from "react-toastify";
// import "react-toastify/dist/ReactToastify.css";

const VideoList = () => {
  const [videos, setVideos] = useState([]);

  useEffect(() => {
    const fetchedVideos = [
      {
        id: 1,
        title: "Awesome Video 1",
        description: "This is an awesome video about cool stuff",
        likes: 1000,
        dislikes: 50,
        videoId: "dQw4w9WgXcQ"
      },
      {
        id: 2,
        title: "Cool Video 2",
        description: "Learn about the latest trends in technology",
        likes: 750,
        dislikes: 25,
        videoId: "M7lc1UVf-VE"
      },
      {
        id: 3,
        title: "Interesting Video 3",
        description: "Discover the wonders of nature in this fascinating documentary",
        likes: 1500,
        dislikes: 75,
        videoId: "OWsyrnOBsJs"
      },
    ];
    setVideos(fetchedVideos);
  }, []);

  return (
   <>
      <h1 className="text-3xl font-bold mb-6 text-center">Video List</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {videos.map((video) => (
          <div key={video.id} className="bg-white rounded-lg shadow-md overflow-hidden">
            <div className="relative pb-[56.25%] h-0 overflow-hidden">
              <iframe 
                src={`https://www.youtube.com/embed/${video.videoId}`}
                title={video.title}
                className="absolute top-0 left-0 w-full h-full"
                frameBorder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
              ></iframe>
            </div>
            <div className="p-4">
              <h2 className="text-xl font-semibold mb-2">{video.title}</h2>
              <p className="text-gray-600 mb-4">{video.description}</p>
              <div className="flex justify-between items-center">
                <div className="flex items-center space-x-2">
                  <FaThumbsUp className="text-blue-500" />
                  <span>{video.likes}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <FaThumbsDown className="text-red-500" />
                  <span>{video.dislikes}</span>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
      
      {/* <ToastContainer position="bottom-right" /> */}
      </>
  );
};

export default VideoList;