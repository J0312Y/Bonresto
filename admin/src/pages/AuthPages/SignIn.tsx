import PageMeta from "../../components/common/PageMeta";
import AuthLayout from "./AuthPageLayout";
import SignInForm from "../../components/auth/SignInForm";

export default function SignIn() {
  return (
    <>
      <PageMeta
        title="Connexion — Bonresto SaaS"
        description="Administration de la plateforme Bonresto"
      />
      <AuthLayout>
        <SignInForm />
      </AuthLayout>
    </>
  );
}
