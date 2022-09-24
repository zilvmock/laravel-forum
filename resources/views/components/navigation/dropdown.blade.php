<div class="dropdown dropdown-end">
  <label tabindex="0" class="btn btn-ghost m-1">
    <div id="image">
      {{$image ?? $image=null}}
    </div>
    <div id="title">
      <a href="#" class="font-bold">
        {{$title}}
      </a>
    </div>
    <div id="icon">
      {{$icon ?? ''}}
    </div>
  </label>
  <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
    {{$content}}
  </ul>
</div>

<script>
  window.addEventListener('load', () => {
    changeSize();
    window.addEventListener('resize', () => {
      changeSize();
    });
  });

  let image = document.getElementById('image');
  let title = document.getElementById('title');
  let icon = document.getElementById('icon');

  function changeSize() {
    let ul = document.getElementById('bc-navbar');
    if (document.body.scrollWidth <= 540) {
      if ({{$image != null}}) {
        title.classList.add('hidden');
        icon.classList.add('hidden');
      } else {
        title.classList.add('hidden');
      }
    } else {
      image.classList.remove('hidden');
      title.classList.remove('hidden');
      icon.classList.remove('hidden');
    }
  }
</script>
