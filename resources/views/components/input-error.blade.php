@props(['name'])

@error($name)
<p class="mt-0 text-red-500 italic text-sm">{{$message}}</p>
@enderror
