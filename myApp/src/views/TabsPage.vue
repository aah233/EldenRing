<template>
  <ion-page>
    <ion-tabs>
      <ion-router-outlet></ion-router-outlet>
      <ion-tab-bar slot="bottom">
        <ion-tab-button tab="tab1" href="/tabs/tab1">
          <img src="../../public/ico/tab2.ico" style="width: 30%; height: 70%; display: block;">
        </ion-tab-button>

        <ion-tab-button tab="tab2" href="/tabs/tab2">
          <img src="../../public/ico/tab1.ico" style="width: 30%; height: 70%; display: block;">
        </ion-tab-button>

        <ion-tab-button tab="tab3" href="/tabs/tab3">
          <img src="../../public/ico/tab3.ico" style="width: 30%; height: 70%; display: block;">
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-page>
</template>

<script setup lang="ts">
import { IonTabBar, IonTabButton, IonTabs, IonPage, IonRouterOutlet } from '@ionic/vue';
</script>
