<template>
   <div>
       <div class="bg-white h-full w-full">
           <div class="md:grid md:grid-cols-3 md:gap-6">
               <div class="md:col-span-1">
                   <div class="font-bold text-xl px-3 pt-3 lg:px-5 lg:pt-5">Profile Information</div>
                   <div class="px-3 lg:px-5">Update Your Account's Profile Information and Email Address</div>
               </div>
               <div class="md:col-span-2">
                   <form>
                       <div class="p-3">
                           <div class="bg-white rounded border-2">
                               <div class="grid grid-cols-6 gap-6">
                                   <div class="col-span-6 sm:col-span-4">
                                       <div class="text-xl p-3 lg:p-5">Profile Photo</div>
                                       <div class="px-3">
                                           <button class="font-bold px-3 border-2 rounded">Select Profile Picture</button>
                                       </div>
                                   </div>
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                                           Username
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                                   </div>
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                           Email
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Email">
                                   </div>
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="fullname">
                                           Fullname
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Fullname">
                                   </div>
                               </div>
                               <div class="flex justify-end px-5 py-5">
                                   <button class="bg-blue-500 rounded w-14 h-7">Save</button>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>

               <div class="md:col-span-1">
                   <div class="font-bold text-xl px-3 pt-3 lg:px-5 lg:pt-5">Update Password</div>
                   <div class="px-3 lg:px-5">Ensure Your Password is using a long, random password to stay secure</div>
               </div>
               <div class="md:col-span-2">
                   <form>
                       <div class="p-3">
                           <div class="bg-white rounded border-2">
                               <div class="grid grid-cols-6 gap-6">
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="cureent-password">
                                           Current Password
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
                                   </div>
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="new-password">
                                           New Password
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Password">
                                   </div>
                                   <div class="px-3 mt-5 col-span-6 sm:col-span-4">
                                       <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm-password">
                                           Confirm Password
                                       </label>
                                       <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Fullname">
                                   </div>
                               </div>
                               <div class="flex justify-end px-5 py-5">
                                   <button class="bg-blue-500 rounded w-14 h-7">Save</button>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</template>
