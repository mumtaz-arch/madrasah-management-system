@props(['key', 'value' => '', 'type' => 'text'])

<div class="relative group inline-block {{ $attributes->get('class') }}">
    <!-- Content -->
    @if($type === 'image')
        {{ $slot }}
    @else
        {!! $value !!}
    @endif

    <!-- Edit Button (Only visible to Admin) -->
    @auth
        {{-- Check using standard role helper --}}
        @if(auth()->user()->isAdmin() || auth()->user()->id == 1) 
            <button 
                x-data
                @click="$dispatch('open-edit-modal', { key: '{{ $key }}' })"
                class="absolute -top-3 -right-3 z-50 bg-yellow-400 text-yellow-900 p-1.5 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110 focus:outline-none"
                title="Edit Content"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        @endif
    @endauth
</div>
