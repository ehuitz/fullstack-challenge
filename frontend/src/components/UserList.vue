<template>

<div class="bg-white">
  <div class="mx-auto max-w-xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-5xl lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">User - Weather</h2>

    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-20 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-8">
      
      <user-card v-for="user in users" :key="user.id" :user="user" />
     
    </div>
  </div>

</div>

</template>
  
<script>
import axios from 'axios';
import UserCard from './UserCard.vue';

export default {
  name: 'UserList',
  components: {
    UserCard,
  },
  data() {
    return {
      users: [],
      isLoading: true,
    };
  },
  async created() {
    try {
      const response = await axios.get('http://localhost/');
      this.users = response.data.users;

    } catch (error) {
      console.error(error);
    } finally {
      this.isLoading = false;
    }
  },
};
</script>
  