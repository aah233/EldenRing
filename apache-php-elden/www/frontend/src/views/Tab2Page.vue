<template>
  <ion-list v-if="loaded && boss">
    <ion-list-header>Album: {{ boss.name }}</ion-list-header>
    <ion-item>
      <ion-thumbnail slot="start">
        <img :src="boss.img" alt="">
      </ion-thumbnail>
      <ion-label>
        <h3>{{ boss.name }}</h3>
        <p>{{ boss.location }}</p> <!-- Asumiendo que la API proporciona una ubicación -->
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

  <ion-button @click="setLoaded()">Pulsa para conocer al jefe random</ion-button>
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
    const boss = ref(null); // Cambiamos bosses a boss para almacenar solo un jefe

    const setLoaded = async () => {
      loaded.value = false; // Comenzamos el estado de carga
      try {
        const response = await fetch('https://eldenring.fanapis.com/api/bosses?limit=100');
        const data = await response.json();
        const randomIndex = Math.floor(Math.random() * data.data.length); // Selecciona un índice aleatorio
        boss.value = data.data[randomIndex]; // Guarda solo un jefe aleatorio
        loaded.value = true;
      } catch (error) {
        console.error("Failed to fetch boss:", error);
        loaded.value = true; // Asegúrate de manejar los errores adecuadamente
      }
    };
    return {
      loaded,
      boss,
      setLoaded,
    };
  },
});
</script>
