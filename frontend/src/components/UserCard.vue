<template>
  <div class="group relative" @click="showMore = !showMore">
    <div
      class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-50">
      <img :src="weatherIconUrl" alt="weather icon"
        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
    </div>
    <div class="mt-4 flex justify-between">
      <div>
        <h3 class="text-m font-bold text-gray-700">
          <a href="#">
            <span aria-hidden="true" class="absolute inset-0"></span>
            {{ user.name }}
          </a>
        </h3>
        <p class="mt-1 text-sm text-gray-800">{{ weatherQuick }}</p>
        <p class="mt-1 text-sm text-gray-600">{{ shortForecast }}</p>
        <p class="mt-1 text-sm text-gray-400">{{ weatherDate }}</p>
      </div>
    </div>
    <div v-if="showMore" class="mt-4">
      <div v-for="(period, index) in weatherPeriods" :key="index">
        <p class="text-sm font-bold text-gray-700">{{ period.name }}</p>
        <p class="mt-1 text-sm text-gray-800">{{ period.temperature + '\u00B0' + period.temperatureUnit  }}</p>
        <p class="mt-1 text-sm text-gray-800">{{ period.detailedForecast }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  name: 'UserCard',
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      showMore: false,
    };
  },
  computed: {
    weatherIconUrl() {
      return this.user.weathers[0].weather.properties.periods[0].icon;
    },
    weatherQuick() {
      return this.user.weathers[0].weather.properties.periods[0].name + ' ' +
       this.user.weathers[0].weather.properties.periods[0].temperature  + '\u00B0' + 
       this.user.weathers[0].weather.properties.periods[0].temperatureUnit;
    },
    weatherDate(){
      const startTime = new Date(this.user.weathers[0].weather.properties.generatedAt);
      const options = { dateStyle: 'long', timeStyle: 'short', hour12: true };
      return startTime.toLocaleString('en-US', options);
    },
    shortForecast(){
      return this.user.weathers[0].weather.properties.periods[0].shortForecast;
    },
    weatherPeriods() {
      return this.user.weathers[0].weather.properties.periods.slice(1);
    },
  }
};
</script>
