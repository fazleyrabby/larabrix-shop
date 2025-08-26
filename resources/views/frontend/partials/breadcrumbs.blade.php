 @php
     $segments = request()->segments();
 @endphp

 <div class="breadcrumbs text-sm">
     <ul class="flex space-x-2">
         <li>
             <a href="{{ url('/') }}">Home</a>
         </li>
         @foreach ($segments as $index => $segment)
             <li>
                 @if ($index + 1 < count($segments))
                     <a href="{{ url(implode('/', array_slice($segments, 0, $index + 1))) }}">
                         {{ ucfirst(str_replace('-', ' ', $segment)) }}
                     </a>
                 @else
                     <span>{{ ucfirst(str_replace('-', ' ', $segment)) }}</span>
                 @endif
             </li>
         @endforeach
     </ul>
 </div>
