import axios from "axios";
import React, { useState, useEffect } from "react";
import { FaThumbsUp, FaThumbsDown, FaChevronDown, FaChevronUp } from "react-icons/fa";
// import { ToastContainer } from "react-toastify";
// import "react-toastify/dist/ReactToastify.css";

  const VideoList = ({videos: localVideos, userLikes }) => {
  const [videos, setVideos] = useState(localVideos);
  const [expandedDescriptions, setExpandedDescriptions] = useState({});
  const [likedVideos, setLikedVideos] = useState({});
  const [dislikedVideos, setDislikedVideos] = useState({});
  
  
  
  useEffect(() => {
    // Initialize liked and disliked states from userLikes
    const liked = [];
    const disliked = [];

    userLikes.forEach(like => {
      if (like.type === 'like') {
        liked[like.video_id] = true; // or you can use like.id if you need to track it
      } else if (like.type === 'dislike') {
        disliked[like.video_id] = true; // same here
      }
    });

    setLikedVideos(liked);
    setDislikedVideos(disliked);

    console.log(likedVideos)
    console.log(dislikedVideos)
  }, [userLikes]);

  

  const toggleDescription = (id) => {
    setExpandedDescriptions(prev => ({
      ...prev,
      [id]: !prev[id]
    }));
  };

  

  const handleLikeDislike = async (videoId, type) => {
    try {
      const response = await axios.post(`/videos/${videoId}/like-or-dislike`, { type });

      setVideos(videos.map(video => 
        video.id === videoId 
          ? { 
              ...video, 
              likes: response.data.like_count, 
              dislikes: response.data.dislike_count 
            } 
          : video
      ));

      if (type === 'like') {
        setLikedVideos((prev) => {

          if (prev[videoId]) {
            const updatedLiked = { ...prev };
            delete updatedLiked[videoId];
            return updatedLiked;
          } 

          return { ...prev, [videoId]: true };
        });
  
        setDislikedVideos((prev) => {
          const updatedDisliked = { ...prev };
          delete updatedDisliked[videoId];  
          return updatedDisliked;
        });

      } else if (type === 'dislike') {
       setDislikedVideos((prev) => {

        if (prev[videoId]) {
          const updatedDisliked = { ...prev };
          delete updatedDisliked[videoId];
          return updatedDisliked;
        } 

        return { ...prev, [videoId]: true };
      });
  
        setLikedVideos((prev) => {
          const updatedLiked = { ...prev };
          delete updatedLiked[videoId];  // Remove from liked if previously liked
          return updatedLiked;
        });
      }
        

    } catch (error) {
      console.error("Error liking/disliking video:", error);
    }
  };
 
  return (
   <>
      <h1 className="text-3xl font-bold mb-6 text-center">Video List</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {videos.map((video) => (
          <div key={video.id} className="bg-white rounded-lg shadow-md overflow-hidden">
            <div className="relative pb-[56.25%] h-0 overflow-hidden">
              <iframe 
                src={video.embed_url}
                title={video.title}
                className="absolute top-0 left-0 w-full h-full"
                frameBorder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
              ></iframe>
            </div>
            <div className="p-4">
              <h2 className="text-xl font-semibold mb-2 truncate">{video.title}</h2>
              <h2 className="text-xl font-semibold mb-2 truncate">Shared by {video.user_name}</h2>
              <div className="text-sm text-gray-700 mb-4">
                  {expandedDescriptions[video.id] || video.description.length <= 100
                    ? video.description
                    : `${video.description.slice(0, 100)}...`}
                  {video.description.length > 100 && (
                    <button
                      onClick={() => toggleDescription(video.id)}
                      className="text-blue-500 hover:text-blue-700 ml-2 focus:outline-none"
                    >
                      {expandedDescriptions[video.id] ? (
                        <>
                          Show Less <FaChevronUp className="inline" />
                        </>
                      ) : (
                        <>
                          Show More <FaChevronDown className="inline" />
                        </>
                      )}
                    </button>
                  )}
                </div>
              <div className="flex justify-between items-center">
                <div className="flex items-center space-x-2">
                  <FaThumbsUp 
                className={`flex items-center transition-all duration-300 cursor-pointer ${
                  likedVideos[video.id] ? 'text-blue-500' : 'text-gray-500'
                } hover:text-blue-500 transform hover:scale-110 focus:outline-none`}
                  onClick={() => handleLikeDislike(video.id, 'like')}
                  />
                  <span>{video.likes}</span>
                </div>
                <div className="flex items-center space-x-2">
                  <FaThumbsDown 
                 className={`flex items-center transition-all duration-300 cursor-pointer ${
                  dislikedVideos[video.id] ? 'text-red-500' : 'text-gray-500'
                } hover:text-red-500 transform hover:scale-110 focus:outline-none`}
                  onClick={() => handleLikeDislike(video.id, 'dislike')} />
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