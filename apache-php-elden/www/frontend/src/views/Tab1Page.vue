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
        <ion-button slot="end" @click="editItem(index)">Edit</ion-button>
      </ion-item>
    </ion-reorder-group>

    <!-- Edit Modal -->
    <ion-modal :is-open="isEditModalOpen" @did-dismiss="closeEditModal">
      <ion-content>
        <ion-header>
          <ion-toolbar>
            <ion-title>Edit Item</ion-title>
            <ion-buttons slot="end">
              <ion-button @click="closeEditModal">Close</ion-button>
            </ion-buttons>
          </ion-toolbar>
        </ion-header>
        <ion-content>
          <ion-item>
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="editableItem.name"></ion-input>
          </ion-item>
          <ion-button expand="full" @click="saveEdit">Save</ion-button>
        </ion-content>
      </ion-content>
    </ion-modal>
  </ion-list>
</template>

<script lang="ts">
import { IonItem, IonLabel, IonList, IonReorder, IonReorderGroup, IonThumbnail, IonButton, IonModal, IonContent, IonHeader, IonToolbar, IonTitle, IonButtons, IonInput } from '@ionic/vue';
import { defineComponent, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
  components: { IonItem, IonLabel, IonList, IonReorder, IonReorderGroup, IonThumbnail, IonButton, IonModal, IonContent, IonHeader, IonToolbar, IonTitle, IonButtons, IonInput },
  setup() {
    const items = ref([]);
    const isEditModalOpen = ref(false);
    const editableItem = ref({ id: '', name: '', index: -1 });

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
      const movedItem = items.value.splice(event.detail.from, 1)[0];
      items.value.splice(event.detail.to, 0, movedItem);
      event.detail.complete();
    };

    const editItem = (index: number) => {
      const item = items.value[index];
      editableItem.value = { id: item.id, name: item.name, index };
      isEditModalOpen.value = true;
    };

    const closeEditModal = () => {
      isEditModalOpen.value = false;
    };

    const saveEdit = async () => {
      const index = editableItem.value.index;
      if (index !== -1) {
        try {
          await axios.put(`https://local-backend.elden.com/api/items/${editableItem.value.id}`, {
            name: editableItem.value.name
          });
          items.value[index].name = editableItem.value.name;
          closeEditModal();
        } catch (error) {
          console.error('Error updating item:', error);
        }
      }
    };

    fetchItems();

    return { items, isEditModalOpen, editableItem, handleReorder, editItem, closeEditModal, saveEdit };
  },
});
</script>

<style scoped>
ion-thumbnail {
  width: 60px;
  height: 60px;
}
</style>
