<x-app-layout>
     <div class="flex-1 h-full bg-white flex flex-col">
          <div class="flex-1 border-t grid grid-cols-4">
              <div class="col-span-1 border-r px-4 h-[calc(100vh-64px)] flex flex-col">
                  @livewire('messages.navigation', ['users' => $users])
              </div>
              <div class="col-span-3 flex flex-col justify-center mx-auto">
                  <div class="font-bold text-lg">
                      No Chats Selected
                  </div>
              </div>
          </div>
     </div>
</x-app-layout>
