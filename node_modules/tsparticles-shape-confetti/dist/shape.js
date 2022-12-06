import { ConfettiDrawer } from "./ConfettiDrawer";
export function loadConfettiShape(tsParticles) {
    tsParticles.addShape("confetti", new ConfettiDrawer());
}
