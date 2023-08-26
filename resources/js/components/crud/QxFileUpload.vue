<template>
  <div class="q-pb-md">
    <div>{{$attrs.label}}</div>
    <div class="container english" @dragover="()=>isActive = true" @dragleave="()=>isActive = false">
      <div class="progress-box" v-if="isSaving">
              <img v-if="imagePreviewUrl" :src="imagePreviewUrl" width="200" />
              <div>
                Uploading {{ fileCount }} files... {{ uploadProgress }}
              </div>
      </div>
      <form enctype="multipart/form-data" novalidate v-if="isInitial && !hasImage">
        <div class="dropbox" v-bind:class="{ active: isActive }">
          <input type="file" :multiple="multiple" :name="uploadFieldName" :disabled="isSaving" @click="clickedButton"
          @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
            accept="application/pdf, application/, image/*" class="input-file">
            <p v-if="isInitial">
              Drag your file(s) here or click to choose from your device.
              <br />
              Max file size: {{ maxFileSizeMb }}MB
            </p>
            
            
        </div>
      </form>
      <!--SUCCESS-->
      <div v-if="isSuccess || (isInitial && hasImage)" class="success-box">
        <div style="text-align: right;">
          <q-btn round flat href="javascript:void(0)" @click="reset()" icon="close" />
          
        </div>
        <img v-if="imagePreviewUrl" :src="imagePreviewUrl" width="200" /><br />
        <span>Uploaded {{ uploadedFiles.length }} file(s) successfully.</span> <br />
        <div v-for="uploadedFile in uploadedFiles" :key="uploadedFile.name">

            <a :href="uploadedFile.url" target="_black">
              <span> {{ uploadedFile.name }}</span> 
            </a>
        </div>

      </div>
      <!--FAILED-->
      
      <div v-if="isFailed">
        <span>Uploaded failed.</span>
        <div v-if="fileSizeError" style="color: red;"> File size too big. Max file size is {{ maxFileSizeMb }}MB</div>
        <p>
          <a href="javascript:void(0)" @click="reset()">Try again</a>
        </p>
        <pre>{{ uploadError }}</pre>
      </div>
    </div>
  </div>

</template>

<script>

import axios from 'axios'

const appConfig = {
  baseUrl: '/api'
}

const upload = function (formData,path) {
    const url = `${appConfig.baseUrl}`+path;
    // console.log(url)
    return axios.post(url, formData).then(resp => resp)
    
}

  const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

  export default {
    name: 'qx-file-upload',
    data() {
      return {
        uploadedFiles: [],
        uploadError: null,
        currentStatus: null,
        uploadFieldName: 'files[]',
        isActive : false,
        imagePreviewUrl: this.imageUrl,
        uploadProgress: 0,
        fileSizeError: false,
      }
    },
    props:{
      maxUploads: {
        required: false,
      },
      path: {
        required: false,
        default: '/upload'
      },
      imageUrl: {
        required: false,
        default: null,
      },
      multiple: {
        required: false,
        default: true,
      },
      maxFileSizeMb: {
        required: false,
        default: 5,
      }
    },
    watch: {
      uploadedFiles :function(){
        if(this.uploadedFiles.length > 0) {
          this.$emit('update:modelValue', this.uploadedFiles[0].url)
        }
        
      }
    },
    computed: {
      isInitial() {
        return this.currentStatus == STATUS_INITIAL;
      },
      isSaving() {
        return this.currentStatus == STATUS_SAVING;
      },
      isSuccess() {
        return this.currentStatus == STATUS_SUCCESS;
      },
      isFailed() {
        return this.currentStatus == STATUS_FAILED;
      },
      hasImage() {
        return this.imagePreviewUrl ? 1 : 0;
      },
      uploadsMaxxed() {
        return this.uploadedFiles.length == this.maxUploads
      },
    },
    methods: {
      clickedButton() {
        // console.log('clicked')
      },
      upload(formData, path) {

        let config = {
            onUploadProgress: progressEvent => {
              
              let percentUploaded = Math.round(progressEvent.loaded / progressEvent.total * 100)
              this.uploadProgress = percentUploaded < 100 ? percentUploaded + "%" : "Uploaded, waiting for save response..."
            }
        }
          const url = `${appConfig.baseUrl}`+path;
          return axios.post(url, formData, config).then(resp => resp)
      },

      reset(init = false) {
        // reset form to initial state
        this.currentStatus = STATUS_INITIAL;
        this.uploadedFiles = [];
        this.uploadError = null;
        this.fileSizeError = false;
        this.imagePreviewUrl = init ? this.imageUrl : null;
      },
      save(formData) {
        // upload data to the server
        this.currentStatus = STATUS_SAVING;
        // const url = `${BASE_URL}/papi/entry/upload`;

        this.upload(formData, this.path)
        //   .then(wait(1500)) // DEV ONLY: wait for 1.5s
          .then(files => {
            this.$emit('uploaded', files)
            this.uploadedFiles = [].concat(files.data);
            this.currentStatus = STATUS_SUCCESS;

          })
          .catch(error => {
            this.uploadError = error.response;
            this.currentStatus = STATUS_FAILED;
            this.$emit('error', error)
          });
      },
      checkFileTooBig(file) {
        let fileSizeMb = Math.round((file.size / (1024 * 1024)));
        if(fileSizeMb > this.maxFileSizeMb) {
          this.currentStatus = STATUS_FAILED;
          this.fileSizeError = true
          return true;
        }
        return false;
        
      },
      filesChange(fieldName, fileList) {

        if(fileList.length <= 0) {
          return false;
        }

        if(this.checkFileTooBig(fileList[0])) {
          return false;
        }
        // handle file changes
        const formData = new FormData();

        if(fileList[0].type.match('image.*')) {
          this.imagePreviewUrl =  URL.createObjectURL(fileList[0])
        }

        if (!fileList.length) return;

        // append the files to FormData
        Array
          .from(Array(fileList.length).keys())
          .map(x => {
            formData.append(fieldName, fileList[x], fileList[x].name);
          });

        // save it
        this.save(formData);
      }
    },
    mounted() {
      this.reset(true);
    },
  }

</script>

<style lang="scss" scoped>
  .dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: whitesmoke;
    color: dimgray;
    padding: 10px 10px;
    min-height: 50px; /* minimum height */
    position: relative;
    cursor: pointer;
    padding: 20px;

  }

  .progress-box, .success-box {
    background: whitesmoke;
    display:fles;
    align-items: center;
    justify-items: center;
    color: dimgray;
    padding: 10px 10px;
    min-height: 50px; /* minimum height */
    position: relative;
    cursor: pointer;
    padding: 20px;
    text-align: center;
  }

  .preview-image {
    height: 80px;
  }

  .input-file {
    top: 0px;
    right: 0px;
    opacity: 0; /* invisible but it's there! */
    width: 100%;
    position: absolute;
    cursor: pointer;
    height: 100px;
    background-color: whitesmoke;
  }

  .dropbox:hover, .active {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }

  .dropbox p {
    font-size: 0.9em;
    text-align: center;
    margin: 0.5rem;
  }

  .uploadsMaxxed{
    display:none;
  }
</style>
