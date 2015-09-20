//
//  WhizHomeViewController.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import UIKit

class WhizHomeViewController: UIViewController, CLLocationManagerDelegate, GMSMapViewDelegate {

    @IBOutlet weak var mapView: GMSMapView!
    let locationManager = CLLocationManager()
    let dataProvider = DataProvider()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        locationManager.delegate = self
        locationManager.requestWhenInUseAuthorization()
        mapView.delegate = self
        // 1
        let labelHeight :CGFloat = 50
        
        self.mapView.padding = UIEdgeInsets(top: self.topLayoutGuide.length, left: 0,
            bottom: labelHeight, right: 0)
        putMarkers()
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func putMarkers(){
        dataProvider.fetchJobs() { jobsArray in
            for job in jobsArray {
                var lat: Double = job.job_latitude!
                var long: Double = job.job_longitude!
                var position = CLLocationCoordinate2DMake(lat, long)
                var marker = GMSMarker(position: position)
                marker.title = job.job_name
                marker.snippet = job.job_description
                marker.userData = job.job_id
                marker.icon = GMSMarker.markerImageWithColor(UIColor(rgba: "#FF9800"))

                marker.map = self.mapView
            }
        }
    }
    
    func mapView(mapView: GMSMapView!, didTapInfoWindowOfMarker marker: GMSMarker!) {
        //Initiate the individual game
        println("asdf")
        let viewController = self.storyboard!.instantiateViewControllerWithIdentifier("IndividualJob") as! IndividualJobViewController
        let navigationController = UINavigationController(rootViewController: viewController)
        self.dataProvider.fetchIndividualJob(marker.userData as! Int){ curJob in
            viewController.currentJob = curJob
            self.presentViewController(navigationController, animated: true, completion: nil)
        }
        
    }

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */
    
    // MARK: - CLLocationManagerDelegate
    //1
  

}

extension WhizHomeViewController: CLLocationManagerDelegate {
    // 2
    func locationManager(manager: CLLocationManager!, didChangeAuthorizationStatus status: CLAuthorizationStatus) {
        // 3
        if status == .AuthorizedWhenInUse {
            
            // 4
            locationManager.startUpdatingLocation()
            
            //5
            mapView.myLocationEnabled = true
            mapView.settings.myLocationButton = true
        }
    }
    
    // 6
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        if let location = locations.first as? CLLocation {
            
            // 7
            mapView.camera = GMSCameraPosition(target: location.coordinate, zoom: 15, bearing: 0, viewingAngle: 0)
            
            // 8
            locationManager.stopUpdatingLocation()
        }
    }
}
