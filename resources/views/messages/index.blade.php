<x-app-layout>
     <div class="flex-1 h-full bg-white flex flex-col">
          {{-- <x-slot name="header">
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  {{ __('Chats') }}
              </h2>
          </x-slot> --}}
          <div class="flex-1 border-t grid grid-cols-4">
              <div class="col-span-1 border-r px-4 h-[calc(100vh-64px)] flex flex-col">
                  <h2 class="font-extrabold text-2xl my-4 text-gray-800 leading-tight">
                      {{ __('Chats') }}
                  </h2>
                  <div class="flex-1 border-t overflow-scroll no-scrollbar">
                      @foreach ($users as $user)
                          @if(!$user->verification?->verified && $user->role->id !== 1)
                              @continue
                          @endif
                          <div class="my-2">
                              <a href="{{ route('messages.show', ['user' => $user->id]) }}">
                                   <div class="flex gap-2 px-2 py-1 hover:bg-gray-100 rounded-lg transition duration-150">
                                       <div>
                                           <x-profile-picture class="h-14" :src="asset($user->profile->url)" />
                                       </div>
                                       <div class="my-auto">
                                           <h1 class="font-bold">
                                               {{ $user->name }}
                                           </h1>
                                       </div>
                                   </div>
                              </a>
                          </div>
                      @endforeach
                  </div>
              </div>
              <div class="col-span-3 flex flex-col justify-center mx-auto">
                  <div class="font-bold text-lg">
                      No Chats Selected
                  </div>
              </div>
          </div>
     </div>
</x-app-layout>
