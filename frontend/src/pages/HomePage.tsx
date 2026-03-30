import { HomeBanner } from '../components/home/HomeBanner'
import { HomeBgFilter } from '../components/home/HomeBgFilter'

export function HomePage() {
  return (
    <div className="bg_home">
      <HomeBanner />
      <HomeBgFilter />
    </div>
  )
}
