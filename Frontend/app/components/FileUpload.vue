<template> 
    <div class="bg-gray-200 max-w-2xl mx-auto p-4">
        <div class="bg-white p-2">
            <label for="">Upload large File  </label>
            <input type="file" class="p-2 border border-gray-200 w-full my-2" @change="handleFileChange" multiple>

            <div
                v-for="(item, index) in files"
                :key="index"
                class="my-3"
              >
                <div class="flex justify-between text-sm mb-1">
                  <span>{{ item.name }}</span>
                  <span>{{ item.progress }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded h-3">
                  <div
                    class="bg-green-500 h-3 rounded transition-all"
                    :style="{ width: item.progress + '%' }"
                  ></div>
                </div>
              </div>

            <button @click="uploadFile" class="bg-green-600 text-white px-4 py-1 rounded-md"> Upload </button>
        </div>
    </div>
</template>

<script setup lang="ts">

    interface FileItem{
        name:string;
        progress: number;
    }

    const selectedFiles = ref<File[]>([])
    const files = ref<FileItem[]>([]);
    const chunk_size = ref<number>(2 * 1024 * 1024);

    const uploading = ref<boolean>(false);
    const uploadId = crypto.randomUUID();

    const handleFileChange = (event:Event) =>{

        const target = event.target as HTMLInputElement;
        if(!target.files) return;

        const fileArray: File[] = Array.from(target.files);
        selectedFiles.value = fileArray;
        
        const newFiles: FileItem[] = [];
        for (const file of fileArray) {
            newFiles.push({
                name: file.name,
                progress: 0,
            });
        }
        files.value = newFiles;
    };

    const uploadFile = async () => {
      for (let i = 0; i < selectedFiles.value.length; i++) {
        const file = selectedFiles.value[i];
        if (!file) continue;

        const totalChunks = Math.ceil(file.size/chunk_size.value);

        for(let j = 0; j < totalChunks; j++){
          const start = j * chunk_size.value;
          const end = Math.min(start + chunk_size.value, file.size);
          const chunk = file.slice(start, end);
          const formData = new FormData();

          formData.append('chunk', chunk);
          formData.append('index', j);
          formData.append('total', totalChunks);
          formData.append('fileName', file.name);
          formData.append('uploadId', uploadId);

          await $fetch('http://127.0.0.1:8000/api/upload', {
            method: 'POST',
            body: formData,
          });

          

          files.value[i].progress = Math.round(((j + 1) / totalChunks) * 100)
        } 
      }
    };

    const beforeUnloadHandler = (e: BeforeUnloadEvent) => {
      if (uploading.value) {
        e.preventDefault()
        e.returnValue = ''
      }
    }

    onMounted(() => {
      window.addEventListener('beforeunload', beforeUnloadHandler)
    })

    onBeforeUnmount(() => {
      window.removeEventListener('beforeunload', beforeUnloadHandler)
    })

</script>