<template>
  <div class="group relative">
    <div
      class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-50">
      <img :src="weatherIconUrl" alt="weather icon"
        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
    </div>
    <div class="mt-4 flex justify-between">
      <div>
        <h3 class="text-sm text-gray-700">
          <a href="#">
            <span aria-hidden="true" class="absolute inset-0"></span>
            {{ user.name }}
          </a>
        </h3>
        <p class="mt-1 text-sm text-gray-500">{{ user.email }}</p>
      </div>
      <!-- <p class="text-sm font-medium text-gray-900">{{ user.weathers[0].weather.properties.periods[0].icon }}</p> -->
    </div>
  </div>
</template>
  
<script>
export default {
  name: 'UserCard',
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  computed: {
    weatherIconUrl() {
      return this.user.weathers[0].weather.properties.periods[0].icon;
    }
  }
};
</script>
