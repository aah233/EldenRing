<template>
  <ion-list>
    <!-- The reorder gesture is disabled by default, enable it to drag and drop items -->
    <ion-reorder-group :disabled="false" @ionItemReorder="handleReorder($event)">
      <ion-item v-for="(item, index) in items" :key="index">
        <ion-thumbnail slot="start">
          <img :src="item.image" />
        </ion-thumbnail>
        <ion-label>
          <h2>{{ item.name }}</h2>
          <p>{{ item.description }}</p>
        </ion-label>
        <ion-reorder slot="end"></ion-reorder>
      </ion-item>
    </ion-reorder-group>
  </ion-list>
</template>

<script lang="ts">
import { IonItem, IonLabel, IonList, IonReorder, IonReorderGroup, IonThumbnail } from '@ionic/vue';
import { defineComponent, ref, onMounted } from 'vue';
import axios from 'axios';

export default defineComponent({
  components: { IonItem, IonLabel, IonList, IonReorder, IonReorderGroup, IonThumbnail },
  setup() {
    const items = ref([]);

    const fetchItems = async () => {
      try {
        const response = await axios.get('https://local-backend.elden.com/api/items');
        items.value = response.data;
      } catch (error) {
        console.error('Error fetching items:', error);
      }
    };

    const handleReorder = (event: CustomEvent) => {
      console.log('Dragged from index', event.detail.from, 'to', event.detail.to);
      // Update the items array based on the reorder event
      const movedItem = items.value.splice(event.detail.from, 1)[0];
      items.value.splice(event.detail.to, 0, movedItem);

      // Finish the reorder
      event.detail.complete();
    };

    onMounted(() => {
      fetchItems();
    });

    return { items, handleReorder };
  },
});
</script>

<style scoped>
ion-thumbnail {
  width: 60px;
  height: 60px;
}
</style>
