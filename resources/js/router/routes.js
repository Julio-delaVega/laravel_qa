import QuestionsPage from "../pages/QuestionsPage";
import QuestionPage from "../pages/QuestionPage";
import MyPostsPage from "../pages/MyPostsPage";
import NotFoundPage from "../pages/NotFoundPage";
import CreateQuestionPage from "../pages/CreateQuestionPage";

const routes = [
    {
        path: "/",
        component: QuestionsPage,
        name: "root"
    },
    {
        path: "/home",
        component: QuestionsPage,
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
        name: "questions.show"
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
