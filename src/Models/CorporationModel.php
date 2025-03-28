<?php
namespace App\Models;
use App\Models\Model;

class CorporationModel extends Model {

    protected $table = "Corporation";

    public function getEntreprises(): array{
        return [
            ['nom' => 'TechCorp', 'secteur' => 'Technologie', 'ville' => 'Paris'],
            ['nom' => 'FinSoft', 'secteur' => 'Finance', 'ville' => 'Londres'],
            ['nom' => 'HealthSolutions', 'secteur' => 'Santé', 'ville' => 'Berlin'],
            ['nom' => 'EduTech', 'secteur' => 'Éducation', 'ville' => 'New York'],
            ['nom' => 'GreenFuture', 'secteur' => 'Écologie', 'ville' => 'Amsterdam'],
            ['nom' => 'AutoMotiveX', 'secteur' => 'Automobile', 'ville' => 'Tokyo'],
            ['nom' => 'MediaWorks', 'secteur' => 'Médias', 'ville' => 'Toronto'],
            ['nom' => 'Foodies', 'secteur' => 'Restauration', 'ville' => 'Rome'],
            ['nom' => 'LogiTrack', 'secteur' => 'Logistique', 'ville' => 'Singapour'],
            ['nom' => 'StyleInc', 'secteur' => 'Mode', 'ville' => 'Milan'],
            ['nom' => 'SmartBuild', 'secteur' => 'Construction', 'ville' => 'Dubaï'],
            ['nom' => 'BioPharma', 'secteur' => 'Pharmaceutique', 'ville' => 'Bâle'],
            ['nom' => 'EnergyNow', 'secteur' => 'Énergie', 'ville' => 'Houston'],
            ['nom' => 'TravelLux', 'secteur' => 'Tourisme', 'ville' => 'Barcelone'],
            ['nom' => 'CryptoWorld', 'secteur' => 'Cryptomonnaie', 'ville' => 'Zurich'],
            ['nom' => 'AeroDynamics', 'secteur' => 'Aérospatiale', 'ville' => 'Seattle'],
            ['nom' => 'AgriGrow', 'secteur' => 'Agriculture', 'ville' => 'Nairobi'],
            ['nom' => 'UrbanInnovations', 'secteur' => 'Urbanisme', 'ville' => 'Melbourne'],
            ['nom' => 'OceanicTech', 'secteur' => 'Maritime', 'ville' => 'Copenhague'],
            ['nom' => 'CleanEnergy', 'secteur' => 'Énergie verte', 'ville' => 'Stockholm'],
            ['nom' => 'GamingZone', 'secteur' => 'Jeux vidéo', 'ville' => 'San Francisco'],
            ['nom' => 'DataSecure', 'secteur' => 'Cybersécurité', 'ville' => 'Tel Aviv'],
            ['nom' => 'Cloudify', 'secteur' => 'Cloud computing', 'ville' => 'Boston'],
            ['nom' => 'RoboTech', 'secteur' => 'Robotique', 'ville' => 'Shanghai'],
            ['nom' => 'NanoFuture', 'secteur' => 'Nanotechnologie', 'ville' => 'Séoul'],
            ['nom' => 'DesignPro', 'secteur' => 'Design', 'ville' => 'Helsinki'],
            ['nom' => 'AutoNext', 'secteur' => 'Technologie automobile', 'ville' => 'Stuttgart'],
            ['nom' => 'WellnessCorp', 'secteur' => 'Bien-être', 'ville' => 'Sydney'],
            ['nom' => 'Sportify', 'secteur' => 'Sport', 'ville' => 'Los Angeles'],
            ['nom' => 'ArtisanWorks', 'secteur' => 'Artisanat', 'ville' => 'Lyon'],
            ['nom' => 'TechWave', 'secteur' => 'Startups', 'ville' => 'San José'],
            ['nom' => 'FashionTrend', 'secteur' => 'Mode', 'ville' => 'Paris'],
            ['nom' => 'EcoFarm', 'secteur' => 'Agriculture bio', 'ville' => 'Buenos Aires'],
            ['nom' => 'HomeComfort', 'secteur' => 'Équipements ménagers', 'ville' => 'Munich'],
            ['nom' => 'VisionaryAI', 'secteur' => 'Intelligence artificielle', 'ville' => 'Cambridge'],
            ['nom' => 'EcoTransport', 'secteur' => 'Mobilité durable', 'ville' => 'Oslo'],
            ['nom' => 'CloudMetrics', 'secteur' => 'Big Data', 'ville' => 'Palo Alto'],
            ['nom' => 'FutureLab', 'secteur' => 'Recherche scientifique', 'ville' => 'Genève'],
            ['nom' => 'SafeNet', 'secteur' => 'Sécurité réseau', 'ville' => 'Anvers'],
            ['nom' => 'DroneTech', 'secteur' => 'Technologie des drones', 'ville' => 'Brisbane'],
            ['nom' => 'FitLife', 'secteur' => 'Fitness', 'ville' => 'Miami'],
            ['nom' => 'UrbanFood', 'secteur' => 'Alimentation urbaine', 'ville' => 'Mexico'],
            ['nom' => 'WaterPure', 'secteur' => 'Traitement de l\eau', 'ville' => 'Cape Town'],
            ['nom' => 'SolarFuture', 'secteur' => 'Énergie solaire', 'ville' => 'Athènes'],
            ['nom' => 'SpaceFrontier', 'secteur' => 'Exploration spatiale', 'ville' => 'Moscou'],
            ['nom' => 'VRExperience', 'secteur' => 'Réalité virtuelle', 'ville' => 'Dublin'],
            ['nom' => 'FoodChain', 'secteur' => 'Distribution alimentaire', 'ville' => 'Hong Kong'],
            ['nom' => 'DigitalArts', 'secteur' => 'Arts numériques', 'ville' => 'Lisbonne'],
            ['nom' => 'BioFuture', 'secteur' => 'Biotechnologie', 'ville' => 'Copenhague'],
        ];
    }
}