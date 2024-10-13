import { Link } from '@inertiajs/react';
export default function Navbar({auth})
{
    return (
<nav className="bg-gray-800 text-white p-4 mb-6 rounded-lg">
        <div className="flex justify-between items-center">
          <div className="flex items-center space-x-4">
                    <Link href={route('home')} className="text-2xl font-bold">ASVIDEO</Link>
                    {auth.user && (
                        <Link
                            href={route('share')}
                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Share
                        </Link>
                    )}
                </div>
          <div className="space-x-4">
          {auth.user ? (
              <>    
                                    
                                  
                                    <span className="text-white font-medium">{auth.user.name}</span>
                                       
                                    <Link
                                        method="post"
                                        href={route('logout')}
                                        as="button"
                                    >
                                        Log Out
                                    </Link>
                                </>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
          </div>
        </div>
      </nav>
    );
}