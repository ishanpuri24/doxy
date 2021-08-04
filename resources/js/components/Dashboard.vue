<template>
  <v-app>
    <v-navigation-drawer v-model="drawer.visible" app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            <a class="home_link" href="/">Doxy.ai</a>
          </v-list-item-title>
          <v-list-item-subtitle>
            Legal Document Generator
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-subheader>Documents</v-subheader>
        <v-list-item-group v-model="current_view.index" color="primary">
          <template v-for="(item, i) in drawer.filtered_items">
            <v-list-item :key="i" link @click="set_active_view(item)">
              <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon
        @click="drawer.visible = !drawer.visible"
      ></v-app-bar-nav-icon>

      <v-toolbar-title>{{ current_view.title }}</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu bottom min-width="200px" rounded offset-y>
        <template v-slot:activator="{ on }">
          <v-btn icon x-large v-on="on">
            <v-avatar color="primary" size="32">
              <v-icon dark> account_circle </v-icon>
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <v-avatar color="primary">
                <v-icon dark> account_circle </v-icon>
              </v-avatar>
              <h3>{{ user.name }}</h3>
              <p class="caption mt-1">
                {{ user.email }}
              </p>
              <v-divider class="my-3"></v-divider>
              <v-btn depressed rounded text @click="redirect('/my-profile')">
                Edit
              </v-btn>
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
    </v-app-bar>

    <v-main>
      <dashboard-item-documents
        v-if="is_active_view('Documents')"
        @notification="notify"
      ></dashboard-item-documents>

      <dashboard-item-category
        v-if="is_active_view('Categories')"
        @notification="notify"
      ></dashboard-item-category>

      <dashboard-item-variations
        v-if="is_active_view('Variations')"
        @notification="notify"
        @redirect="redirect"
      ></dashboard-item-variations>

      <dashboard-item-qa
        v-if="is_active_view('Question & Answers')"
        @notification="notify"
      ></dashboard-item-qa>

      <dashboard-item-user-documents
        v-if="is_active_view('User Documents')"
        :user="user"
        @notification="notify"
        @redirect="redirect"
      ></dashboard-item-user-documents>

      <dashboard-item-custom-user-documents
        v-if="is_active_view('Custom Documents')"
        :user="user"
        @notification="notify"
        @redirect="redirect"
      ></dashboard-item-custom-user-documents>

      <dashboard-item-signatures
        :user="user"
        v-if="is_active_view('User Signatures')"
        @notification="notify"
      ></dashboard-item-signatures>

      <dashboard-item-shared-documents
        :user="user"
        v-if="is_active_view('Shared Documents')"
        @notification="notify"
      ></dashboard-item-shared-documents>

      <dashboard-item-request-signatures
        :user="user"
        @notification="notify"
        v-if="is_active_view('Request Signatures')"
      ></dashboard-item-request-signatures>

      <dashboard-item-requested-signaures
        :user="user"
        @notification="notify"
        v-if="is_active_view('Requested Signatures')"
      ></dashboard-item-requested-signaures>
    </v-main>

    <v-snackbar v-model="snackbar.is_open" :timeout="snackbar.timeout">
      {{ snackbar.text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          :color="snackbar.color"
          text
          v-bind="attrs"
          @click="snackbar.is_open = false"
        >
          <v-icon> close </v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>
<script>
import DashboardItemRequestedSignaures from "./DashboardItemRequestedSignaures.vue";
export default {
  components: { DashboardItemRequestedSignaures },
  name: "Dashboard",
  props: ["userJson"],

  data() {
    return {
      current_view: {
        index: 0,
        title: null,
      },

      drawer: {
        visible: null,
        filtered_items: [], // filtered by role
        items: [
          {
            title: "Documents",
            full_title: "Documents",
            icon: "article",
            roles: ["admin"],
          },
          {
            title: "Categories",
            full_title: "Document Categories",
            icon: "category",
            roles: ["admin"],
          },
          {
            title: "Variations",
            full_title: "Document Variations",
            icon: "file_copy",
            roles: ["admin"],
          },
          {
            title: "Question & Answers",
            full_title: "Document Questions & Answers",
            icon: "contact_support",
            roles: ["admin"],
          },
          {
            title: "User Documents",
            full_title: "User Documents",
            icon: "description",
            roles: ["admin", "user"],
          },
          {
            title: "Custom Documents",
            full_title: "Custom User Documents",
            icon: "picture_as_pdf",
            roles: ["admin", "user"],
          },
          {
            title: "User Signatures",
            full_title: "User Signatures",
            icon: "edit",
            roles: ["admin", "user"],
          },
          {
            title: "Request Signatures",
            full_title: "Request Signatures",
            icon: "border_color",
            roles: ["admin", "user"],
          },
          {
            title: "Requested Signatures",
            full_title: "Requested Signatures",
            icon: "history_edu",
            roles: ["admin", "user"],
          },
          {
            title: "Shared Documents",
            full_title: "Shared Documents",
            icon: "share",
            roles: ["admin", "user"],
          },
        ],
      },

      user: {},

      snackbar: {
        is_open: false,
        text: null,
        timeout: 5000,
        color: "blue",
      },
    };
  },

  mounted() {
    this.user = JSON.parse(this.userJson);
    this.drawer.filtered_items = this.filter_drawer_items(this.user.role);
    this.parseURLHash();
  },

  methods: {
    parseURLHash() {
      const hash = window.location.hash;
      if (!hash) {
        this.current_view.title = "Documents";
        this.current_view.index = this.getItemIndex("Documents");
      }

      switch (hash) {
        case "#documents":
          this.current_view.title = "Documents";
          this.current_view.index = this.getItemIndex("Documents");
          break;

        case "#categories":
          this.current_view.title = "Categories";
          this.current_view.index = this.getItemIndex("Categories");
          break;

        case "#variations":
          this.current_view.title = "Variations";
          this.current_view.index = this.getItemIndex("Variations");
          break;

        case "#questions":
          this.current_view.title = "Question & Answers";
          this.current_view.index = this.getItemIndex("Question & Answers");
          break;

        case "#user-documents":
          this.current_view.title = "User Documents";
          this.current_view.index = this.getItemIndex("User Documents");
          break;

        case "#custom-documents":
          this.current_view.title = "Custom Documents";
          this.current_view.index = this.getItemIndex("Custom Documents");
          break;

        case "#user-signatures":
          this.current_view.title = "User Signatures";
          this.current_view.index = this.getItemIndex("User Signatures");
          break;

        case "#request-signatures":
          this.current_view.title = "Request Signatures";
          this.current_view.index = this.getItemIndex("Request Signatures");
          break;          

        case "#requested-signatures":
          this.current_view.title = "Requested Signatures";
          this.current_view.index = this.getItemIndex("Requested Signatures");
          break;          

        case "#shared-documents":
          this.current_view.title = "Shared Documents";
          this.current_view.index = this.getItemIndex("Shared Documents");
          break;          
      }
    },

    getItemIndex(title) {
      return this.drawer.filtered_items.findIndex(
        (item) => item.title === title
      );
    },

    filter_drawer_items(user_role) {
      return this.drawer.items.filter((item) => {
        return item.roles.includes(user_role);
      });
    },

    redirect(url) {
      window.open(url, "_blank").focus();
    },

    set_active_view(item) {
      const index = this.drawer.filtered_items.indexOf(item);

      this.current_view.index = index;
      this.current_view.title = this.drawer.filtered_items[index].title;
    },

    is_active_view(view_title) {
      return this.current_view.title === view_title;
    },

    notify(data) {
      this.snackbar.text = data.message;
      this.snackbar.color = data.color;
      this.snackbar.is_open = true;
    },
  },
};
</script>

<style lang="scss" scoped>
.v-avatar {
  color: white;
}

a.home_link {
  text-decoration: none;
}
</style>
