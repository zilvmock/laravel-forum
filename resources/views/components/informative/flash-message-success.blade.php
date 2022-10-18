@if(session()->has('message'))
  <div x-data="{show: true}" x-init="setTimeout(()=>show=false, 3000)" x-show="show"
       class="alert alert-success shadow-lg fixed top-4 left-1/2 -translate-x-1/2 w-max z-10">
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <span>{{session('message')}}</span>
    </div>
  </div>
@endif
