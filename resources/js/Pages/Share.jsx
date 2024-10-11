import React, { useState } from "react";
import { FaYoutube, FaTags } from "react-icons/fa";
import { MdCancel, MdShare } from "react-icons/md";

const Share = () => {
  const [videoUrl, setVideoUrl] = useState("");
  const [description, setDescription] = useState("");
  const [tags, setTags] = useState("");
  const [errors, setErrors] = useState({});
  const [videoPreview, setVideoPreview] = useState(null);

  const validateForm = () => {
    let newErrors = {};
    if (!videoUrl) newErrors.videoUrl = "YouTube URL is required";
    else if (!isValidYouTubeUrl(videoUrl)) newErrors.videoUrl = "Invalid YouTube URL";
    if (description.length > 500) newErrors.description = "Description too long (max 500 characters)";
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const isValidYouTubeUrl = (url) => {
    const regExp = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([\w-]{11})$/;
    return regExp.test(url);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (validateForm()) {
      console.log("Form submitted", { videoUrl, description, tags });
      // Here you would typically send the data to your backend
    }
  };

  const handleVideoUrlChange = (e) => {
    const url = e.target.value;
    setVideoUrl(url);
    if (isValidYouTubeUrl(url)) {
      const videoId = url.split("v=")[1].split("&")[0];
      setVideoPreview({
        id: videoId,
        thumbnail: `https://img.youtube.com/vi/${videoId}/0.jpg`,
        title: "YouTube Video Title", // In a real app, you'd fetch this from YouTube API
        duration: "10:00" // In a real app, you'd fetch this from YouTube API
      });
    } else {
      setVideoPreview(null);
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div className="px-4 py-5 sm:p-6">
          <h2 className="text-2xl font-bold text-gray-900 mb-4">Share YouTube Video</h2>
          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="videoUrl" className="block text-sm font-medium text-gray-700">
                YouTube Video URL
              </label>
              <div className="mt-1 relative rounded-md shadow-sm">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <FaYoutube className="h-5 w-5 text-gray-400" aria-hidden="true" />
                </div>
                <input
                  type="text"
                  id="videoUrl"
                  className={`block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 ${errors.videoUrl ? 'border-red-300' : ''}`}
                  placeholder="https://www.youtube.com/watch?v=..."
                  value={videoUrl}
                  onChange={handleVideoUrlChange}
                  aria-describedby="videoUrl-error"
                />
              </div>
              {errors.videoUrl && (
                <p className="mt-2 text-sm text-red-600" id="videoUrl-error">
                  {errors.videoUrl}
                </p>
              )}
            </div>

            {/* <div>
              <label htmlFor="description" className="block text-sm font-medium text-gray-700">
                Description (optional)
              </label>
              <div className="mt-1">
                <textarea
                  id="description"
                  rows={3}
                  className={`shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md ${errors.description ? 'border-red-300' : ''}`}
                  placeholder="Add a description..."
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  aria-describedby="description-error"
                />
              </div>
              {errors.description && (
                <p className="mt-2 text-sm text-red-600" id="description-error">
                  {errors.description}
                </p>
              )}
            </div> */}

            

            {videoPreview && (
              <div className="mt-4 bg-gray-50 rounded-md p-4 animate-fade-in">
                <h3 className="text-lg font-medium text-gray-900 mb-2">Video Preview</h3>
                <div className="aspect-w-16 aspect-h-9">
                  <img
                    src={videoPreview.thumbnail}
                    alt="Video thumbnail"
                    className="object-cover rounded-md"
                  />
                </div>
                <p className="mt-2 text-sm text-gray-600">{videoPreview.title}</p>
                <p className="text-xs text-gray-500">Duration: {videoPreview.duration}</p>
              </div>
            )}

            <div className="flex justify-end space-x-3">
              <button
                type="button"
                className="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                onClick={() => {
                  setVideoUrl('');
                  setDescription('');
                  setTags('');
                  setErrors({});
                  setVideoPreview(null);
                }}
              >
                <MdCancel className="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                Cancel
              </button>
              <button
                type="submit"
                className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <MdShare className="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                Share Video
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Share;