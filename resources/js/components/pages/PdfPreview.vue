<script>
export default {
  props: ['isOpen', 'path', 'onClose'],
}
</script>

<template>
  <Modal :value="isOpen" title="Preview attachment" :mask-closable="false" width="600" :styles="{ top: '5px' }"
    :closable="true" @on-visible-change="onClose">
    <iframe width="100%" height="600px" :src="path"></iframe>
  </Modal>
</template>