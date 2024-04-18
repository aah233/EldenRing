<template>
  <ion-list v-if="loaded">
    <ion-list-header>Albums</ion-list-header>
    <ion-item>
      <ion-thumbnail slot="start">
        <img :src="bosses[2].img" alt="">
      </ion-thumbnail>
      <ion-label>
        <h3>Abbey Road</h3>
        <p>The Beatles</p>
        <p>{{ bosses[2].name }}</p>
      </ion-label>
    </ion-item>
  </ion-list>

  <ion-list v-if="!loaded">
    <ion-list-header>
      <ion-skeleton-text :animated="true" style="width: 80px"></ion-skeleton-text>
    </ion-list-header>
    <ion-item>
      <ion-thumbnail slot="start">
        <ion-skeleton-text :animated="true"></ion-skeleton-text>
      </ion-thumbnail>
      <ion-label>
        <h3>
          <ion-skeleton-text :animated="true" style="width: 80%;"></ion-skeleton-text>
        </h3>
        <p>
          <ion-skeleton-text :animated="true" style="width: 60%;"></ion-skeleton-text>
        </p>
        <p>
          <ion-skeleton-text :animated="true" style="width: 30%;"></ion-skeleton-text>
        </p>
      </ion-label>
    </ion-item>
  </ion-list>

  <ion-button @click="setLoaded()">Toggle</ion-button>
</template>

<script lang="ts">
import {
  IonButton,
  IonItem,
  IonLabel,
  IonList,
  IonListHeader,
  IonSkeletonText,
  IonThumbnail,
} from '@ionic/vue';
import { musicalNotes } from 'ionicons/icons';
import { defineComponent, ref } from 'vue';

export default defineComponent({
  components: {
    IonButton,
    IonItem,
    IonLabel,
    IonList,
    IonListHeader,
    IonSkeletonText,
    IonThumbnail,
  },
  setup() {
    const loaded = ref(false);
    const bosses = ref([]);
    const setLoaded = async () => {
      loaded.value = false; // Set loading to false while fetching
      try {
        const response = await fetch('https://eldenring.fanapis.com/api/bosses?limit=100');
        const data = await response.json();
        bosses.value = data.data; // Assuming the API returns data in a 'data' key
        loaded.value = true;
      } catch (error) {
        console.error("Failed to fetch bosses:", error);
        loaded.value = true; // In real scenario, handle errors properly
      }
    };
    return {
      loaded,
      musicalNotes,
      bosses,
      setLoaded,
    };
  },
});
</script>