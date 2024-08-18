@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Frequently Asked Questions</h1>

  <div class="mt-6 space-y-4">
    <!-- FAQ Card 1 -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
      <div class="py-4 px-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          <button type="button" class="flex items-center justify-between w-full text-left" data-accordion-target="#accordion-flush-body-1" aria-expanded="false" aria-controls="accordion-flush-body-1">
            <span>FAQ 1?</span>
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" data-accordion-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-flush-body-1" class="hidden mt-2">
          <p class="text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eleifend velit vel nunc dignissim laoreet. Mauris justo sem, hendrerit eu lectus eget, laoreet ornare nibh. Sed euismod, ex nec fermentum dapibus, metus ligula vulputate quam, a elementum leo ante ut lectus. Phasellus ut hendrerit dui, at rhoncus eros.</p>
          <p class="text-gray-500 dark:text-gray-400 mt-2">Suspendisse potenti. Phasellus hendrerit finibus augue in dictum. Quisque sagittis iaculis ipsum sollicitudin malesuada. Morbi vestibulum nulla odio, in placerat sem malesuada nec. Mauris vel nunc nibh. Duis et augue eu erat sodales condimentum. Fusce a cursus dui, nec aliquet est.</p>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
      <div class="py-4 px-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          <button type="button" class="flex items-center justify-between w-full text-left" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
            <span>FAQ 2?</span>
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" data-accordion-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-flush-body-2" class="hidden mt-2">
          <p class="text-gray-500 dark:text-gray-400">Integer hendrerit purus ante, eget posuere nunc bibendum ut. Maecenas sagittis sollicitudin placerat. Nunc cursus finibus erat, a aliquam felis facilisis id. Nullam purus tellus, ornare ac odio at, fringilla gravida ex. Etiam pellentesque ipsum non nunc posuere, nec dictum augue venenatis. </p>
          <p class="text-gray-500 dark:text-gray-400 mt-2">Vivamus cursus augue nec semper ultricies. Nulla id varius libero, eu tempus nunc. Fusce luctus at dolor ut accumsan. Sed aliquam pretium purus, at elementum diam interdum eu. Donec a enim dolor. Vestibulum lacinia orci quis commodo blandit.</p>
        </div>
      </div>
    </div>

  </div>
</div>

<a href="https://wa.me/6285158705880" target="_blank" class="fixed bottom-4 right-4 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
  <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.388 16.388a10.05 10.05 0 001.58-1.805A10.027 10.027 0 0021 12a10.027 10.027 0 00-3.032-6.576A10.045 10.045 0 0012 3a10.05 10.05 0 00-1.88.196A10.049 10.049 0 005 5.697 10.027 10.027 0 002 12a10.027 10.027 0 001.388 5.583 10.037 10.037 0 001.58 1.805A10.04 10.04 0 0012 21a10.045 10.045 0 005.67-1.674A10.05 10.05 0 0016.388 16.388z"/>
  </svg>
</a>

@endsection
