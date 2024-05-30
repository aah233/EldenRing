<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Noticias Elden Ring</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content color="light">
      <ion-list :inset="true">
        <ion-item v-for="(news, index) in newsList" :key="index" :button="true" @click="openLink(news.link)">
          <ion-icon :color="cardColors[index % cardColors.length]" slot="start" :icon="listCircle"
            size="large"></ion-icon>
          <ion-label>
            <strong>{{ news.title }}</strong>
          </ion-label>
          <ion-note slot="end">{{ news.link }}</ion-note>
        </ion-item>
      </ion-list>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import {
  IonContent,
  IonHeader,
  IonIcon,
  IonItem,
  IonLabel,
  IonList,
  IonNote,
  IonTitle,
  IonToolbar
} from '@ionic/vue';
import { defineComponent, ref, onMounted } from 'vue';
import { chevronForward, listCircle } from 'ionicons/icons';
import axios from 'axios';

export default defineComponent({
  components: {
    IonContent,
    IonHeader,
    IonIcon,
    IonItem,
    IonLabel,
    IonList,
    IonNote,
    IonTitle,
    IonToolbar
  },
  setup() {
    const newsList = ref([]);
    const cardColors = ['primary', 'secondary', 'tertiary', 'success', 'warning', 'danger', 'light', 'medium', 'dark'];

    const fetchNews = async () => {
      try {
        const { data } = await axios.get('https://local-backend.elden.com/api/news');
        newsList.value = data;
      } catch (error) {
        console.error('Error fetching news:', error);
      }
    };

    const openLink = (link: string) => {
      window.open(link, '_blank');
    };

    onMounted(() => {
      fetchNews();
    });

    return { newsList, cardColors, listCircle, openLink };
  }
});
</script>

<style scoped>
.unread-indicator {
  background: var(--ion-color-primary);
  width: 10px;
  height: 10px;
  border-radius: 100%;
  position: absolute;
  inset-inline-start: 12px;
  top: 12px;
}

.metadata-end-wrapper {
  position: absolute;
  top: 10px;
  inset-inline-end: 10px;
  font-size: 0.8rem;
  display: flex;
  align-items: center;
}

ion-label strong {
  display: block;
  max-width: calc(100% - 60px);
  overflow: hidden;
  text-overflow: ellipsis;
}

ion-label ion-note {
  font-size: 0.9rem;
}
</style>
