import QuestionsPage from "../pages/QuestionsPage";
import QuestionPage from "../pages/QuestionPage";
import MyPostsPage from "../pages/MyPostsPage";
import CreateQuestionPage from "../pages/CreateQuestionPage";
import EditQuestionPage from "../pages/EditQuestionPage";
import NotFoundPage from "../pages/NotFoundPage";

const routes = [
    {
        path: "/",
        component: QuestionsPage,
        name: "root"
    },
    {
        path: "/home",
        component: MyPostsPage,
        name: "home"
    },
    {
        path: "/questions",
        component: QuestionsPage,
        name: "questions"
    },
    {
        path: "/questions/create",
        component: CreateQuestionPage,
        name: "questions.create"
    },
    {
        path: "/questions/:slug",
        component: QuestionPage,
        name: "questions.show",
        props: true
    },
    {
        path: "/questions/:id/edit",
        component: EditQuestionPage,
        name: "questions.edit"
    },
    {
        path: "/my-posts",
        component: MyPostsPage,
        name: "my-posts",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "*",
        component: NotFoundPage,
        name: "not-found"
    }
];

export default routes;
